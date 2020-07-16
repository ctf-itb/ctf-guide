FROM ubuntu:18.04

RUN apt update && \
	apt -y install socat

RUN useradd -ms /bin/bash guide

RUN mkdir /home/guide/chall

COPY bof0 /home/guide/chall
COPY flag.txt /home/guide/chall
COPY run.sh /home/guide/chall

EXPOSE 10001

RUN chown -R root:root /home/guide/chall
RUN chmod -R 555 /home/guide/chall
USER guide
WORKDIR /home/guide/chall

CMD ["./run.sh"]