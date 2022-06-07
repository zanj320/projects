using System;
using System.Collections.Generic;

namespace _4vrsto {
    class Igralec {
        private int y, x;
        private char[,] polje;

        Igralec(int y, int x) {
            this.y = y;
            this.x = x;

            this.polje = new char[this.y, this.x];

            for (int i = 0; i < this.y; i++) {
                for (int j = 0; j < this.x; j++) {
                    this.polje[i, j] = '-';
                }
            }
        }

        private void izbirnaVrstica() {
            for (int i = 1; i <= x; i++) {
                Console.Write(i);
                if (i + 1 != x + 1)
                    Console.Write(" ");
            }

            Console.WriteLine();

            for (int i = 1; i <= x; i++) {
                Console.Write("v");
                if (i + 1 != x + 1)
                    Console.Write(" ");
            }
            Console.WriteLine();
        }
        private void izpisi(char[,] podanoPolje) {
            izbirnaVrstica();
            
            for (int i = 0; i < podanoPolje.GetLength(0); i++) {
                for (int j = 0; j < podanoPolje.GetLength(1); j++) {
                    Console.Write(podanoPolje[i, j]);
                    if (j + 1 != podanoPolje.GetLength(1))
                        Console.Write(" ");
                }
                Console.WriteLine();
            }
            Console.WriteLine();
        }

        private void igra() {
            string izbiraStr;
            int izbira;

            Console.WriteLine("Zacni, izbiraj med 1 in " + x);
            izpisi(polje);

            while (true) {
                do {
                    izbiraStr = Console.ReadLine();
                    if (!int.TryParse(izbiraStr, out izbira)) { }
                    else
                        izbira = Int32.Parse(izbiraStr);
                    
                } while (izbira > x || izbira < 0 || !int.TryParse(izbiraStr, out izbira));

                if (vnos(izbira, 'X')) {
                    racunalnik('X', 'O');
                }
                izpisi(polje);

                if (zmaga('X', polje)) {
                    izpisi(polje);
                    Console.WriteLine("Zmagal!");
                    break;
                }

                if (konec()) {
                    izpisi(polje);
                    Console.WriteLine("Konec, ni vec polj!");
                    break;
                }
            }
        }
        private bool vnos(int izbira, char znak) {
            if (naVoljoStolpec(izbira) > 0) {
                int preji = 0, kamy = 0, kamx = 0;

                for (int i = 0; i < polje.GetLength(0); i++) {
                    if (polje[i, izbira - 1] != '-') {
                        polje[preji, izbira - 1] = znak;
                        kamy = preji;
                        kamx = izbira - 1;
                        break;
                    } else if (i + 1 == polje.GetLength(0)) {
                        polje[i, izbira - 1] = znak;
                        kamy = i;
                        kamx = izbira - 1;
                        break;
                    }

                    preji = i;
                }
                return true;
            } else {
                Console.WriteLine("Poln stolpec!");
                return false;
            }
        }
        private int naVoljoStolpec(int izbira) {
            int koliko = 0;
            for (int i = 0; i < polje.GetLength(0); i++) {
                if (polje[i, izbira - 1] == '-')
                    koliko++;
                else
                    break;
            }
            return koliko;
        }

        private bool zmaga(char znak, char[,] podanoPolje) {
            //gleda po horizontalah
            int stX;
            for (int i = 0; i < y; i++) {
                stX = 0;

                for (int j = 0; j < x; j++) {
                    if (podanoPolje[i, j] == znak)
                        stX++;
                    else if (stX != 0)
                        stX = 0;

                    if (stX >= 4)
                        return true;
                }
            }

            //gleda po vertikalah
            for (int i = 0; i < x; i++) {
                stX = 0;

                for (int j = 0; j < y; j++) {
                    if (podanoPolje[j, i] == znak)
                        stX++;
                    else if (stX != 0)
                        stX = 0;

                    if (stX >= 4)
                        return true;
                }
            }

            //gleda po diagonalah /
            for (int i = 3; i < podanoPolje.GetLength(1) - 1; i++) {
                stX = 0;

                for (int j = 0, k = i; k >= 0 && j < podanoPolje.GetLength(0); j++, k--) {
                    if (podanoPolje[j, k] == znak)
                        stX++;
                    else if (stX != 0)
                        stX = 0;

                    if (stX >= 4)
                        return true;
                }
            }
            
            for (int l = 0; l < podanoPolje.GetLength(0) - 3; l++) {
                stX = 0;

                for (int j = l, k = podanoPolje.GetLength(1) - 1; k >= 0 && j < podanoPolje.GetLength(0); j++, k--) {
                    if (podanoPolje[j, k] == znak)
                        stX++;
                    else if (stX != 0)
                        stX = 0;

                    if (stX >= 4)
                        return true;
                }
            }

            //gleda po diagonalah \
            for (int i = podanoPolje.GetLength(1) - 4; i > 0; i--) {
                stX = 0;

                for (int j = 0, k = i; j < podanoPolje.GetLength(0) && k < podanoPolje.GetLength(1); j++, k++) {
                    if (podanoPolje[j, k] == znak)
                        stX++;
                    else if (stX != 0)
                        stX = 0;

                    if (stX >= 4)
                        return true;
                }
            }

            for (int l = 0; l < podanoPolje.GetLength(0) - 3; l++) {
                stX = 0;

                for (int j = l, k = 0; j < podanoPolje.GetLength(0) && k < podanoPolje.GetLength(1); j++, k++) {
                    if (podanoPolje[j, k] == znak)
                        stX++;
                    else if (stX != 0)
                        stX = 0;

                    if (stX >= 4)
                        return true;
                }
            }

            return false;
        }

        private bool konec() {
            for (int i = 0; i < polje.GetLength(0); i++) {
                for (int j = 0; j < polje.GetLength(1); j++) {
                    if (polje[j, i] != '-')
                        break;
                    else
                        return false;
                }
            }

            return true;
        }

        private void racunalnik(char znakPreverjanja, char znakPreprecitev) {
            List<string> kandidatiX = new List<string>();
            
            //gleda po diagonalah /
            for (int i = 3; i < polje.GetLength(1) - 1; i++) {
                int stX = 0;
                int prejK = 0;
                bool dej = false;

                for (int j = 0, k = i; k >= 0 && j < polje.GetLength(0); j++, k--) {
                    if (polje[j, k] == znakPreverjanja) {
                        stX++;

                        if (j > 0 && k < polje.GetLength(1) - 1 && polje[j - 1, k + 1] == '-' && polje[j, k + 1] != '-') {
                            prejK = k + 1;
                            dej = true;
                        }

                        if ((j == polje.GetLength(0) - 1 || k == 0) && dej)
                            kandidatiX.Add(prejK + ":" + stX);
                    } else {
                        if (j > 0 && k < polje.GetLength(1) - 1 && polje[j - 1, k + 1] == znakPreverjanja && dej) {
                            kandidatiX.Add(prejK + ":" + stX);
                            dej = false;
                        }

                        if (j > 0 && k < polje.GetLength(1) - 1 && polje[j - 1, k + 1] == znakPreverjanja && ((polje[j, k] == '-' && j < polje.GetLength(0) - 1 && polje[j + 1, k] != '-') || j == polje.GetLength(0) - 1))
                            kandidatiX.Add(k + ":" + stX);

                        if (stX != 0)
                            stX = 0;
                    }
                }
            }

            for (int l = 0; l < polje.GetLength(0) - 3; l++) {
                int stX = 0;
                int prejK = 0;
                bool dej = false;

                for (int j = l, k = polje.GetLength(1) - 1; k >= 0 && j < polje.GetLength(0); j++, k--) {
                    if (polje[j, k] == znakPreverjanja) {
                        stX++;

                        if (j > 0 && k < polje.GetLength(1) - 1 && polje[j - 1, k + 1] == '-' && polje[j, k + 1] != '-') {
                            prejK = k + 1;
                            dej = true;
                        }

                        if ((j == polje.GetLength(0) - 1 || k == 0) && dej)
                            kandidatiX.Add(prejK + ":" + stX);
                    } else {
                        if (j > 0 && k < polje.GetLength(1) - 1 && polje[j - 1, k + 1] == znakPreverjanja && dej) {
                            kandidatiX.Add(prejK + ":" + stX);
                            dej = false;
                        }

                        if (j > 0 && k < polje.GetLength(1) - 1 && polje[j - 1, k + 1] == znakPreverjanja && ((polje[j, k] == '-' && j < polje.GetLength(0) - 1 && polje[j + 1, k] != '-') || j == polje.GetLength(0) - 1))
                            kandidatiX.Add(k + ":" + stX);

                        if (stX != 0)
                            stX = 0;
                    }
                }
            }
            
            //gleda po diagonalah \
            for (int i = polje.GetLength(1) - 4; i > 0; i--) {
                int stX = 0;
                int prejK = 0;
                bool dej = false;

                for (int j = 0, k = i; j < polje.GetLength(0) && k < polje.GetLength(1); j++, k++) {
                    if (polje[j, k] == znakPreverjanja) {
                        stX++;

                        if (j > 0 && k > 0 && polje[j - 1, k - 1] == '-' && polje[j, k - 1] != '-') {
                            prejK = k - 1;
                            dej = true;
                        }

                        if ((j == polje.GetLength(0) - 1 || k == polje.GetLength(1) - 1) && dej)
                            kandidatiX.Add(prejK + ":" + stX);
                    } else {
                        if (j > 0 && k > 0 && polje[j - 1, k - 1] == znakPreverjanja && dej) {
                            kandidatiX.Add(prejK + ":" + stX);
                            dej = false;
                        }

                        if (j > 0 && k > 0 && polje[j - 1, k - 1] == znakPreverjanja && ((polje[j, k] == '-' && j < polje.GetLength(0) - 1 && polje[j + 1, k] != '-') || j == polje.GetLength(0) - 1))
                            kandidatiX.Add(k + ":" + stX);

                        if (stX != 0)
                            stX = 0;
                    }
                }
            }

            for (int l = 0; l < polje.GetLength(0) - 3; l++) {
                int stX = 0;
                int prejK = 0;
                bool dej = false;

                for (int j = l, k = 0; j < polje.GetLength(0) && k < polje.GetLength(1); j++, k++) {
                    if (polje[j, k] == znakPreverjanja) {
                        stX++;

                        if (j > 0 && k > 0 && polje[j - 1, k - 1] == '-' && polje[j, k - 1] != '-') {
                            prejK = k - 1;
                            dej = true;
                        }

                        if ((j == polje.GetLength(0) - 1 || k == polje.GetLength(1) - 1) && dej)
                            kandidatiX.Add(prejK + ":" + stX);
                    } else {
                        if (j > 0 && k > 0 && polje[j - 1, k - 1] == znakPreverjanja && dej) {
                            kandidatiX.Add(prejK + ":" + stX);
                            dej = false;
                        }

                        if (j > 0 && k > 0 && polje[j - 1, k - 1] == znakPreverjanja && ((polje[j, k] == '-' && j < polje.GetLength(0) - 1 && polje[j + 1, k] != '-') || j == polje.GetLength(0) - 1))
                            kandidatiX.Add(k + ":" + stX);

                        if (stX != 0)
                            stX = 0;
                    }
                }
            }

            //pregleda horizontalne
            for (int i = 0; i < polje.GetLength(0); i++) {
                int stX = 0;
                int prejJ = 0;
                bool dej = false;

                for (int j = 0; j < polje.GetLength(1); j++) {
                    if (polje[i, j] == znakPreverjanja) {
                        stX++;

                        if (((j > 0 && j < polje.GetLength(1) - 1 && polje[i, j + 1] != znakPreverjanja) || j == polje.GetLength(1) - 1) && dej) {
                            kandidatiX.Add(prejJ + ":" + stX);
                            dej = false;
                        }
                    } else {
                        if (j < polje.GetLength(1) - 1 && polje[i, j] == '-' && polje[i, j + 1] == znakPreverjanja && ((i < polje.GetLength(0) - 1 && polje[i + 1, j] != '-') || i == polje.GetLength(0) - 1)) {
                            prejJ = j;
                            dej = true;
                        }

                        if (j > 0 && polje[i, j] == '-' && polje[i, j - 1] == znakPreverjanja && ((i < polje.GetLength(0) - 1 && polje[i + 1, j] != '-') || i == polje.GetLength(0) - 1))
                            kandidatiX.Add(j + ":" + stX);

                        if (stX != 0)
                            stX = 0;
                    }
                }
            }

            // pregleda vertikale
            for (int i = 0; i < polje.GetLength(1); i++) {
                int stX = 0;
                bool dej = false;

                for (int j = 0; j < polje.GetLength(0); j++) {
                    if (polje[j, i] == znakPreverjanja && j > 0) {
                        stX++;

                        if (((j < polje.GetLength(0) - 1 && polje[j + 1, i] != znakPreverjanja) || j == polje.GetLength(0) - 1) && dej) {
                            kandidatiX.Add(i + ":" + stX);
                            dej = false;
                            break;
                        }
                    } else {
                        if (polje[j, i] == '-' && j < polje.GetLength(0) - 1 && polje[j + 1, i] == znakPreverjanja)
                            dej = true;
                    }
                }
            }/**/

            foreach (string eli in kandidatiX) {
                Console.WriteLine(Int32.Parse(eli.Split(':')[0]) + ":" + Int32.Parse(eli.Split(':')[1]));
            }

            List<int> boZmaga = new List<int>();
            List<int> polniStolpci = new List<int>();
            Random rnd = new Random();

             while (true) {
                char[,] prejPolje = (char[,])polje.Clone();
                int indexKam = DajNovIndex(kandidatiX, boZmaga, polniStolpci);

                if (indexKam != -1) {
                    Console.WriteLine(indexKam + "l");
                    bool pom = false;
                    if (naVoljoStolpec(indexKam + 1) > 1) {
                        vnos(indexKam + 1, znakPreprecitev);
                        vnos(indexKam + 1, znakPreverjanja);
                        pom = true;
                    }

                    if (pom && zmaga('X', polje)) {
                        polje = (char[,])prejPolje.Clone();

                        if (!boZmaga.Contains(indexKam))
                            boZmaga.Add(indexKam);
                    } else {
                        polje = (char[,])prejPolje.Clone();
                        if (naVoljoStolpec(indexKam + 1) > 0) {
                            vnos(indexKam + 1, znakPreprecitev);
                            break;
                        } else {
                            if (!polniStolpci.Contains(indexKam))
                                polniStolpci.Add(indexKam);
                        }
                    }
                } else {
                    int a = rnd.Next(7);
                    Console.WriteLine(a + "a");
                    if (naVoljoStolpec(a + 1) > 0) {
                        vnos(a + 1, znakPreprecitev);
                        break;
                    } else {
                        if (!polniStolpci.Contains(a))
                            polniStolpci.Add(a);
                    }
                }
            }
        }

        private int DajNovIndex(List<string> podaniKandidatiX, List<int> boZmaga, List<int> polniStolpci) {
            int najvDol = 0;
            int indexDol = 0;

            foreach (string el in podaniKandidatiX) {
                int trenDol = Int32.Parse(el.Split(':')[1]);
                int trenIndex = Int32.Parse(el.Split(':')[0]);

                if (trenDol > najvDol && !boZmaga.Contains(trenIndex) && !polniStolpci.Contains(trenIndex)) {
                    najvDol = trenDol;
                    indexDol = trenIndex;
                }
                //Console.WriteLine(el);
            }

            if (najvDol > 0)
                return indexDol;
            else 
                return - 1;
        }

        static void Main(string[] args) {
            Igralec rac = new Igralec(6,7);
            rac.igra();

            Console.ReadLine();
        }
    }
}
