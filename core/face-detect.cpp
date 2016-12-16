#include <iostream>
#include <opencv2/opencv.hpp>

using namespace std;
using namespace cv;

const char *keys = {
    "{ i | input | | Input [directory]/filename}"  // -i, --input
    "{ o | output| | Output [directory]/filename}" // -o, --output
};

int main(int argc, const char **argv) {

  // command line parser
  CommandLineParser parser(argc, argv, keys);
  string input_file = parser.get<string>("input");
  string output_file = parser.get<string>("output");
  // parser.printParams(); // 印出所有可以用的參數

  // read image
  Mat img = imread(input_file);
  if (img.empty()) {
    cout << "ERROR! Canot Load Source Image!" << endl;
    return -1;
  }

  // face detect
  string cascade_file = "haarcascade_frontalface_alt.xml";
  CascadeClassifier cascade;
  cascade.load(cascade_file);
  vector<Rect> faces;
  Mat gray;
  cvtColor(img, gray, CV_BGR2GRAY);
  equalizeHist(gray, gray);
  cascade.detectMultiScale(gray, faces, 1.2, 3);

  // draw rectangle
  Mat src_copy = img.clone();
  for (int i = 0; i < faces.size(); i++) {
    rectangle(src_copy, faces[i], CV_RGB(0, 255, 0), 4, 8, 0);
  }

  imwrite(output_file, src_copy);
  // imshow("test", src_copy);
  // waitKey(0);
  return 0;
}

/*
g++ `pkg-config --cflags --libs opencv` face-detect.cpp -o face-detect
./face-detect -i="../lena.jpg" -o="afters/lena.jpg"
*/
