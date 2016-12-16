# Simple Face Detecter

## Require
- PHP
- OpenCV 2.4.*

## Usage

Compile cpp with opencv  
```
g++ `pkg-config --cflags --libs opencv` face-detect.cpp -o face-detect
```

Test
```
./face-detect -i="../lena.jpg" -o="afters/lena.jpg"
```
