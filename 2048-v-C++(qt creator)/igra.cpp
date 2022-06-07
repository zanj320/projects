#include "igra.h"
#include "ui_igra.h"

#include <QPainter>
#include <QKeyEvent>
#include <QPixmap>
#include <QPalette>
#include <QString>
#include <QDebug>

igra::igra(QWidget *parent) : QWidget(parent),ui(new Ui::igra) {
    ui->setupUi(this);
    setFixedSize(540,375);
    preveri_za_premaknit = false;
    pike=0;
    nastavi_element();

    connect(ui->start_gumb, SIGNAL(clicked()), SLOT(start_gumb()));
    connect(ui->exit_gumb, SIGNAL(clicked()), SLOT(exit_gumb()));
}

igra::~igra() {
    delete ui;
}

void igra::on_start_gumb_clicked() {
    preveri_za_premaknit = true;
    pike=0;
    nastavi_element();

    postavi_random();
    postavi_random();

    ui->stanje->setText("Poteka igranje");
    ui->izpis_pik->setText("0");

    update();
}

void igra::paintEvent(QPaintEvent *event) {
    QWidget::paintEvent(event);
    QPainter painter(this);
    painter.fillRect(QRect(10, 10, x_celotne_tabele, y_celotne_tabele), QColor(187, 173, 160));

    for(int vrstica=0; vrstica<st_el_x; vrstica++) {
        for(int stolpec=0; stolpec<st_el_y; stolpec++) {
            painter.fillRect(20 + (10 + element_y_vel)*vrstica, 20 + (10 + element_x_vel)*stolpec, element_y_vel, element_x_vel, QColor(205, 193, 179));
        }
    }

    for(int vrstica=0; vrstica<st_el_x; vrstica++) {
        for(int stolpec=0; stolpec<st_el_y; stolpec++) {
            if(tab[vrstica][stolpec] != 0) {
                painter.drawPixmap(20 + (10 + element_y_vel)*vrstica, 20 + (10 + element_x_vel)*stolpec, element_y_vel, element_x_vel, QPixmap(getBlockColor(tab[vrstica][stolpec])));
            }
            else {
                painter.fillRect(20 + (10 + element_y_vel)*vrstica, 20 + (10 + element_x_vel)*stolpec, element_y_vel, element_x_vel, QColor(205, 193, 179));
            }
        }
    }
}

void igra::keyPressEvent(QKeyEvent *event) {
    QWidget::keyPressEvent(event);
    if(!preveri_za_premaknit) {
        return;
    }

    QWidget::keyPressEvent(event);
    switch(event->key()) {
        case 87: izr_elemente(UP);
            break;
        case 83: izr_elemente(DOWN);
            break;
        case 65: izr_elemente(LEFT);
            break;
        case 68: izr_elemente(RIGHT);
            break;
        default:
            break;
    }
}

void igra::nastavi_element() {
    for (int vrstica=0; vrstica<4; vrstica++) {
        for (int stolpec=0; stolpec<4; stolpec++) {
            tab[vrstica][stolpec] = 0;
        }
    }
}

int igra::getPrazenElement() {
    int stej = 0;
    for(int vrstica=0; vrstica<st_el_x; vrstica++) {
        for(int stolpec=0; stolpec<st_el_y; stolpec++) {
            if(tab[vrstica][stolpec] == 0) {
                stej++;
            }
        }
    }
    return stej;
}

void igra::postavi_random() {
    int st=0, random;

    random = qrand() % getPrazenElement();
    //nafila 2 random
    for(int vrstica=0; vrstica<st_el_x; vrstica++) {
        for(int stolpec=0; stolpec<st_el_y; stolpec++) {
            if(tab[vrstica][stolpec] == 0 && st++ == random) {
                tab[vrstica][stolpec] = (qrand()%2 + 1) * 2;
                qDebug() << "Katera spawnana:" << tab[vrstica][stolpec];
                qDebug() << "Stolpec: " << vrstica+1;
                qDebug() << "Vrstica: " << stolpec+1;
                return;
            }
        }
    }
}

QString igra::getBlockColor(int pom) {
    switch(pom) {
    case 2:
return ":/slike/2.png";
    case 4:
return ":/slike/4.png";
    case 8:
return ":/slike/8.png";
    case 16:
return ":/slike/16.png";
    case 32:
return ":/slike/32.png";
    case 64:
return ":/slike/64.png";
    case 128:
return ":/slike/128.png";
    case 256:
return ":/slike/256.png";
    case 512:
return ":/slike/512.png";
    case 1024:
return ":/slike/1024.png";
    case 2048:
return ":/slike/2048.png";
    }
}

igra::Preveri igra::preveri_element() {
    for(int vrstica=0; vrstica<st_el_x; vrstica++) {
        for(int stolpec=0; stolpec<st_el_y; stolpec++) {
            if(tab[vrstica][stolpec] == zmaga) {
                return WIN;
            }
        }
    }
    for(int vrstica=0; vrstica<st_el_x; vrstica++) {
        for(int stolpec=0; stolpec<st_el_y; stolpec++) {
            if(tab[vrstica][stolpec] == 0) {
                return PRAZNA;
            }
        }
    }
    for(int vrstica=0; vrstica<st_el_x; vrstica++) {
        for(int stolpec=0; stolpec<st_el_y; stolpec++) {
            if((stolpec < 3) && (tab[vrstica][stolpec] == tab[vrstica][stolpec + 1] || tab[stolpec][vrstica] == tab[stolpec + 1][vrstica])) {
                return PRAZNA;
            }
        }
    }
    return LOSE;
}
//izracuna glede na tipko(smer)
void igra::izr_elemente(int smer) {
    int f0=0, fb=0, fm=0, dx=0, dy=0, nx=0, ny=0;
    for(int j=0; j<st_el_x; j++) {
        for(int k=0; k<st_el_y-1; k++) {
            if(fb == 1) {
                fb = 0;
                break;
            }
            for(int i=0; i<st_el_y-1; i++) {
                switch(smer) {
                    case LEFT:
                        {
                            dx = i;
                            dy = j;
                            nx = 1;
                            ny = 0;
                            break;
                        }
                    case DOWN:
                        {
                            dx = j;
                            dy = 3 - i;
                            nx = 0;
                            ny = -1;
                            break;
                        }
                    case RIGHT:
                        {
                            dx = 3 - i;
                            dy = j;
                            nx = -1;
                            ny = 0;
                            break;
                        }
                    case UP:
                        {
                            dx = j;
                            dy = i;
                            nx = 0;
                            ny = 1;
                            break;
                        }
                    default: break;
                }

                if(tab[dx][dy] == 0) {
                    if(tab[dx+nx][dy+ny] !=0) {
                        f0 = 1;
                    }
                    tab[dx][dy] = tab[dx + nx][dy + ny];
                    tab[dx + nx][dy + ny] = 0;
                }
                else if(tab[dx][dy] != 0 && tab[dx][dy] == tab[dx + nx][dy + ny]) {
                    tab[dx][dy] = tab[dx][dy] + tab[dx + nx][dy + ny];
                    tab[dx + nx][dy + ny] = 0;
                    pike =pike + tab[dx][dy];
                    qDebug() << "pike: " << pike;
                    fb = 1;
                    fm = 1;
                }
            }
        }
    }

    if(getPrazenElement() > 0 &&( f0 == 1 || fm == 1 )) {
        postavi_random();
    }

    if(preveri_element() == WIN) {
        ui->stanje->setText("WINNER!");
        preveri_za_premaknit = false;
    }
    else if(preveri_element() == LOSE) {
        ui->stanje->setText("LOOSER!");
        preveri_za_premaknit = false;
    }

    ui->izpis_pik->setText(QString::number(pike));
    update();
}

void igra::on_exit_gumb_clicked() {
    close();
}
