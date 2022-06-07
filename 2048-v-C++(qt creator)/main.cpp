#include "igra.h"
#include <QApplication>
#include <QString>

int main(int argc, char *argv[]) {

    QApplication a(argc, argv);
    igra w;
    w.setWindowTitle(QString("zan_igra_2048"));
    w.show();

    return a.exec();
}
