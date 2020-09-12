# Cryptography
Cryptography challenges mainly deals with the process of encrypting and decrypting data using some algorithms. The challenges include classical cryptography (such as Caesar Cipher) and modern cryptography (such as AES and RSA). To solve the challenges, the contestants need to find and exploit the vulnerabilities of the used algorithm. In many cases, deep understanding in mathematics and scripting ability is required to solve the challenges efficiently.

## Table of Contents
- [Introduction](../introduction.md)
- [Web Exploitation](../web/web.md)
- [Digital Forensics](../foren/foren.md)
- **[Cryptography](../crypto/crypto.md)**
- [Binary Exploitation](../pwn/pwn.md)
- [Reverse Engineering](../rev/rev.md)

## Tools
The tools you might need to solve cryptography challenges:
- Python modules ([PyCryptodome](https://pycryptodome.readthedocs.io/en/latest/src/introduction.html), [gmpy2](https://gmpy2.readthedocs.io/en/latest/intro.html), [pwntools](http://docs.pwntools.com/en/stable/), etc), you know it's python dude.
- Mathematics software system ([SageMath](https://www.sagemath.org/)) to solve mathematical problems using brain or (with some luck) brawn.
- Online tools to factorize some number ([factordb](http://factordb.com/), [alpetron](https://www.alpertron.com.ar/ECM.HTM), etc), general crypto solver ([cryptii](https://cryptii.com/), [dcode](https://www.dcode.fr/), etc), or else ([wolframalpha](https://www.wolframalpha.com/)).
- Another tools, such as [RsaCtfTool](https://github.com/Ganapati/RsaCtfTool), [xortool](https://github.com/hellman/xortool), etc.

## Example Problem
Is it really secure algorithm??

[chall](example/chall.txt)

## How to Solve
From the challenge, we got `n`, `e`, and `c`. It is a typical RSA challenge (there is also hint from the problem desc: really secure algorithm (RSA)).

First of all, you must know the algorithm used in RSA. Read it [here](https://en.wikipedia.org/wiki/RSA_(cryptosystem)#Operation) or somewhere else.

Knowing the algorithm, let's try to factor the `n` number in [factordb](http://factordb.com/). Well, we got 2 number, let's call it `p` and `q`.

p = 33372027594978156556226010605355114227940760344767554666784520987023841729210037080257448673296881877565718986258036932062711
q = 64135289477071580278790190170577389084825014742943447208116859632024532344630238623598752668347708737661925585694639798853367

Next, calculate `phi`.

`phi = (p - 1) * (q - 1)`\
`phi = 2140324650240744961264423072839333563008614715144755017797754920881418023447140136643345519095804679610992851872470914587687298754604485313310619754320029186553180340912603879017884504312838403856515485700993615480396424774279472227006542299206581860`

Then, we can calculate the private key exponent, `d`. Here we use `gmpy2`.

`import gmpy2`\
`d = gmpy2.invert(e, phi)`\
`d = 1219002363472329316632678572665837077877528004905520939230037996503041169769564562618818603930146413036298872224725717654149810234132887053185714832075764978825457518728410705223332728199047961645304133836997233492855592278022423674340390891560261753`

At last, we can calculate the plaintext and convert it to string.

`from Crypto.Util.number import long_to_bytes as lb`\
`flag = lb(pow(c, d, n))`

The flag is: `CTFGUIDE{iT5_r3alLy_5iCk_Al6or1tHm}`

## External Resources
*TBD*
