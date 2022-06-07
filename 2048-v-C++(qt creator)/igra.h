#ifndef IGRA_H
#define IGRA_H
#define y_celotne_tabele 350
#define x_celotne_tabele 350
#define st_el_x 4
#define st_el_y 4
#define zmaga 2048
#define element_x_vel 75
#define element_y_vel 75

#include <QWidget>
#include <QString>
#include <QKeyEvent>
#include <QPaintEvent>

namespace Ui {
class igra;
}

class igra : public QWidget {
    Q_OBJECT  

public:
    enum Preveri {
        WIN,
        LOSE,
        PRAZNA
    };

    enum Smer {
        UP,
        DOWN,
        LEFT,
        RIGHT
    };
    QString getBlockColor(int pom);
    explicit igra(QWidget *parent = 0);
    ~igra();

private Q_SLOTS:
    void on_start_gumb_clicked();
    void on_exit_gumb_clicked();

private:
    virtual void paintEvent(QPaintEvent *event) override;
    virtual void keyPressEvent(QKeyEvent *event) override;

    void nastavi_element();
    int getPrazenElement();
    void postavi_random();
    Preveri preveri_element();
    void izr_elemente(int smer);

    Ui::igra *ui;
    int tab[st_el_x][st_el_y];
    bool preveri_za_premaknit;
    int pike;

};

#endif // IGRA_H
