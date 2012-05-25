#!/bin/sh

PATH=/usr/bin:/bin

## CPU usage
# percent per second
awk '/^cpu /{print "cpu:COUNTER:user:"$2":nice:"$3":sys:"$4":idle:"$5":wait:"$6":irq:"$7":softirq:"$8}' /proc/stat

## Load averege
# 1, 5 and 15 minutes
awk '{print "la:GAUGE:la1:"$1":la5:"$2":la15:"$3}' /proc/loadavg

## IO stat
# read, write - Input/Output operations
# readsec, writesec - read or write sectors (usually 1 sec = 512 bytes)
awk '{print "io-"FILENAME":COUNTER:read:"$1":write:"$5":readsec:"$2":writesec:"$6}' 2>/dev/null /sys/block/cciss*/stat | sed 's%/sys/block/\([^/]*\)/stat%\1%' | tr -d "!"
awk '{print "io-"FILENAME":COUNTER:read:"$1":write:"$5":readsec:"$2":writesec:"$6}' 2>/dev/null /sys/block/[hs]d*/stat | sed 's%/sys/block/\([^/]*\)/stat%\1%'

## Mem stat
awk '{a[$1]=$2*1024}END{print "mem:GAUGE:free:"a["MemFree:"]+a["Buffers:"]+a["Cached:"]":total:"a["MemTotal:"]":swapfree:"a["SwapFree:"]":swaptotal:"a["SwapTotal:"]":cache:"a["Buffers:"]+a["Cached:"]}' /proc/meminfo

## Net stat
# rx, tx - packets
# rxb, txb - bytes
cat /proc/net/dev | tr ":" " " | awk '/^  eth|^ bond/{print "net-"$1":COUNTER:rxb:"$2":rx:"$3":txb:"$10":tx:"$11}'

## FS usage
df -kPT -x tmpfs -x devtmpfs | awk '/\//{print "fs-"$7":GAUGE:total:"$3*1024":used:"$4*1024}' | tr "/" "_"

