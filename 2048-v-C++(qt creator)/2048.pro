#-------------------------------------------------
#
# Project created by QtCreator 2019-04-29T17:12:23
#
#-------------------------------------------------

QT       += core gui

greaterThan(QT_MAJOR_VERSION, 4): QT += widgets

TARGET = 2048
TEMPLATE = app

msvc{
    CONFIG +=c++11
}else{
    QMAKE_CXXFLAGS += -std=c++11
}

SOURCES += main.cpp\
        igra.cpp

HEADERS  += igra.h

FORMS    += igra.ui

RESOURCES += \
    grafika.qrc
