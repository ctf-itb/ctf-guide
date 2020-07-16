// gcc bof0.c -o bof0 -no-pie

#include <stdio.h>
#include <stdlib.h>
#include <string.h>

void readFlag(){
	char flag[32];
	FILE *fptr;
	fptr = fopen("flag.txt", "r");
	fread(&flag, sizeof(char), 32, fptr);
	puts(flag);
}

void vuln(){
	char input[8];
	char string[8] = "stif";
	printf("your input: ");
	gets(input);

	printf("string is: %s\n", string);

	if(strcmp(string, "h3h3") == 0){
		puts("congrats! here's your flag");
		readFlag();
	}
	else{
		printf("not yet :(\nkeep trying!\n");
	}
}

int main(){
	setbuf(stdout, NULL);
	puts("hi! change the string variable to h3h3 and you'll get your flag!");
	vuln();
	exit(0);
	return 0;
}