# Forensics
Forensics challenges can include file format analysis, steganography, memory dump analysis, or network packet capture analysis. Forensics challenges can also consist of binary data and cryptography (XOR and hex). Some of the challenges require a lot of guessing and some of them require a lot of basic knowledges, especially scripting.

## Table of Contents
- [Introduction](../introduction.md)
- [Web Exploitation](../web/web.md)
- **[Digital Forensics](../foren/foren.md)**
- [Cryptography](../crypto/crypto.md)
- [Binary Exploitation](../pwn/pwn.md)
- [Reverse Engineering](../rev/rev.md)

## Tools
The tools you might need to solve Forensics challenges:
- File format analysis tools: pngcheck, binwalk, fsck, exiftool and much more.
- Stegano tools: steghide, stegolsb, and much more.
- Memory dump analysis tools: [volatility](http://volatilityfoundation.org/) and [cheatsheet](https://digital-forensics.sans.org/media/volatility-memory-forensics-cheat-sheet.pdf)
- Networking tools: [wireshark](https://www.wireshark.org/) (windows) and [tshark](https://www.wireshark.org/docs/man-pages/tshark.html) (linux)

## Example Problem
Do you know the NIM of this person in the picture?

You can find the file [here](./example/flag.jpg).

## How to Solve
### Observation
Check the file format first by using `file flag.jpg` command in linux.

`flag.jpg: JPEG image data, JFIF standard 1.01, aspect ratio, density 1x1, segment length 16, baseline, precision 8, 225x225, components 3
`

The file is indeed a jpg image and there is no error. So we can conclude this is a steganography challenge.

### Figuring out the passphrase
From the challenge description, we need to guess the NIM of the person in the picture. So we know that the NIM is the passphrase. You can search the picture in google and you will find:

![Image](example/googlesearch.jpg)

Then you can use a NIM finder and search `Steve Bezalel`. You will get the NIM `13518018`.

### Get the flag
Steganography can consist of a payload and a passphrase and one of the tools that use this concept is steghide. Run steghide for `flag.jpg` with passphrase `13518018`, then you will get the flag.

Command:

`steghide extract -p 13518018 -sf flag.jpg -xf flag.txt; cat flag.txt`

Output:

`
	wrote extracted data to "flag.txt".
	CTFGUIDE{th1s_1s_f0r3ns1cks}
`
