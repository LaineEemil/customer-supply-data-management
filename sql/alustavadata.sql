INSERT INTO asiakas (atunnus,nimi,osoite,postiosoite,puhnro,sposti)
values ('asiakas35435m34k5m3k5','Malli Asiakas','Kaarikatu 66','37120','+358456234','malli.asiakas@gmail.com');
INSERT INTO asiakas (atunnus,nimi,osoite,postiosoite,puhnro,sposti)
values ('asiakas33242g24','Maski Salainen','Lokkikuja 6','00455','+358456234','m.salainen@gmail.com');
INSERT INTO asiakas (atunnus,nimi,osoite,postiosoite,puhnro,sposti)
values ('asiakas43243223grfdg','Kake Asfaltti','Nallikatu 4','00700','+3584324324','asfaltti55@gmail.com');


INSERT INTO tyokohde (kohdetunnus,atunnus,kuvaus,osoite,postiosoite,suunnittelualennus,tyoalennus,aputyoalennus)
values ('kohde543n53534yg3g5','asiakas33242g24','Ulkovalot','Lokkikuja 6','00445',20,20,20);
INSERT INTO tyokohde (kohdetunnus,atunnus,kuvaus,osoite,postiosoite,suunnittelualennus,tyoalennus,aputyoalennus)
values ('kohde543n534nj5n3jk45','asiakas35435m34k5m3k5','Patterit','Kaarikatu 66','37120',0,0,0);
INSERT INTO tyokohde (kohdetunnus,atunnus,kuvaus,osoite,postiosoite,suunnittelualennus,tyoalennus,aputyoalennus)
values ('kohde54654h45h5','asiakas35435m34k5m3k5','Sähkökaappi','Hallikatu 41','04324',0,0,0);
INSERT INTO tyokohde (kohdetunnus,atunnus,kuvaus,osoite,postiosoite,suunnittelualennus,tyoalennus,aputyoalennus)
values ('kohde543n534nj5n3j6677k45','asiakas43243223grfdg','Sulakkeen vaihto','Nallikatu 64','00700',0,0,0);


INSERT INTO tyotunnit (tuntitunnus,kohdetunnus,paivamaara,tyonmaara,tyotapa)
values ('tuntiasdasd32424543','kohde543n534nj5n3jk45','03-03-2020',5,'tyo');
INSERT INTO tyotunnit (tuntitunnus,kohdetunnus,paivamaara,tyonmaara,tyotapa)
values ('tuntiasda234wqewqe3','kohde543n534nj5n3jk45','13-03-2020',6,'tyo');
INSERT INTO tyotunnit (tuntitunnus,kohdetunnus,paivamaara,tyonmaara,tyotapa)
values ('tuntiasdas324deqweqwe543','kohde543n534nj5n3jk45','14-03-2020',5,'tyo');
INSERT INTO tyotunnit (tuntitunnus,kohdetunnus,paivamaara,tyonmaara,tyotapa)
values ('tuntiasqeqw324e543','kohde543n534nj5n3jk45','15-03-2020',1,'tyo');
INSERT INTO tyotunnit (tuntitunnus,kohdetunnus,paivamaara,tyonmaara,tyotapa)
values ('tuntiasdqweq234we3','kohde543n534nj5n3jk45','17-03-2020',2,'tyo');
INSERT INTO tyotunnit (tuntitunnus,kohdetunnus,paivamaara,tyonmaara,tyotapa)
values ('tuntiasdqre324w4','kohde543n53534yg3g5','03-03-2020',5,'suunnittelu');
INSERT INTO tyotunnit (tuntitunnus,kohdetunnus,paivamaara,tyonmaara,tyotapa)
values ('tuntiasdqw234er43r3','kohde543n53534yg3g5','05-03-2020',8,'tyo');
INSERT INTO tyotunnit (tuntitunnus,kohdetunnus,paivamaara,tyonmaara,tyotapa)
values ('tuntiasdqwr34qwr43rr343','kohde543n53534yg3g5','07-03-2020',5,'tyo');
INSERT INTO tyotunnit (tuntitunnus,kohdetunnus,paivamaara,tyonmaara,tyotapa)
values ('tuntiasd43r43r443243r3','kohde543n53534yg3g5','13-03-2020',5,'aputyo');


INSERT INTO tarvikkeet (tarviketunnus,tuotetunnus,nimi,kuvaus,yksikko,varastotilanne,ostohinta,myyntihinta,alv)
values ('tarvike5235235325327r43r3','tuote543n323r23rg5','Kuparijohto','Peruskamaa','m',45,3.99,19.99,24);
INSERT INTO tarvikkeet (tarviketunnus,tuotetunnus,nimi,kuvaus,yksikko,varastotilanne,ostohinta,myyntihinta,alv)
values ('tarvike523765737656346r3','tuote543nasdasrg5','Pistoke','Hyvänlaatuinen saksa','kpl',444,5.99,13.99,24);
INSERT INTO tarvikkeet (tarviketunnus,tuotetunnus,nimi,kuvaus,yksikko,varastotilanne,ostohinta,myyntihinta,alv)
values ('tarvike52385654765358r3','tuote543n3asdasd3rg5','Sulake 20amp','Halvin malli','kpl',555,0.39,2.99,24);
INSERT INTO tarvikkeet (tarviketunnus,tuotetunnus,nimi,kuvaus,yksikko,varastotilanne,ostohinta,myyntihinta,alv)
values ('tarvike52359767569r43r3','tuote54asdsad23rg5','Katkaisija','Vakio valkoinen kiina','kpl',666,2.99,9.99,24);
INSERT INTO tarvikkeet (tarviketunnus,tuotetunnus,nimi,kuvaus,yksikko,varastotilanne,ostohinta,myyntihinta,alv)
values ('tarvike5235230776580873r3','tuote543dsadg5','Sokerinpala','Vakio 3cm kokoinen','kpl',777,0.99,5.99,24);
INSERT INTO tarvikkeet (tarviketunnus,tuotetunnus,nimi,kuvaus,yksikko,varastotilanne,ostohinta,myyntihinta,alv)
values ('tarvike5235239876598r3','tuote543n32dsag5','Ruuvi 5cm','Perus ruuveja','pkt',145,9.99,29.99,24);
INSERT INTO tarvikkeet (tarviketunnus,tuotetunnus,nimi,kuvaus,yksikko,varastotilanne,ostohinta,myyntihinta,alv)
values ('tarvike54324265gsdgds8r3','tuote543gdssg4tg5','Opaskirja','Sähkötietoja','kpl',10,9.99,29.99,10);
INSERT INTO tarvikkeet (tarviketunnus,tuotetunnus,nimi,kuvaus,yksikko,varastotilanne,ostohinta,myyntihinta,alv)
values ('tarvike52hjn5j34j5n','tuote543nlk34m5kl34mn53nhb','Pistorasia','perus valkoinen kiina','kpl',166,1.99,2.99,24);
INSERT INTO tarvikkeet (tarviketunnus,tuotetunnus,nimi,kuvaus,yksikko,varastotilanne,ostohinta,myyntihinta,alv)
values ('tarvikejn54j3k5njk345njk','tuoten4k5n4jk3','Sähköjohto','punainen saksa','m',244,3.99,6.99,24);


INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettyasdsad534543563','kohde543n53534yg3g5','tarvike5235235325327r43r3','Kuparijohto',3,'03-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettyasad5532gfgh553','kohde543n53534yg3g5','tarvike523765737656346r3','Pistoke',5,'06-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettygmkdfsgmlkm5kl3','kohde543n53534yg3g5','tarvike52359767569r43r3','Katkaisija',10,'08-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettymfnwkeomrk43','kohde543n53534yg3g5','tarvike5235235325327r43r3','Kuparijohto',1,'09-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettymdksmflksdmlkdsmfk940','kohde543n53534yg3g5','tarvike523765737656346r3','Pistoke',7,'16-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettynfdsknmflmsdlkf4','kohde543n53534yg3g5','tarvike52359767569r43r3','Katkaisija',8,'18-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettymdnk43b5h34b54','kohde543n53534yg3g5','tarvike52hjn5j34j5n','Pistorasia',7,'21-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettynfdbrwjhbrhb5','kohde543n53534yg3g5','tarvikejn54j3k5njk345njk','Sähköjohto',8,'22-09-2019');

INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettyasdsad3563','kohde543n534nj5n3jk45','tarvike5235235325327r43r3','Kuparijohto',3,'03-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettyasagdfgfd53','kohde543n534nj5n3jk45','tarvike523765737656346r3','Pistoke',5,'06-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettygmkhgjjkl3','kohde543n534nj5n3jk45','tarvike52359767569r43r3','Katkaisija',10,'08-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettymfjhljhlrk43','kohde543n534nj5n3jk45','tarvike5235235325327r43r3','Kuparijohto',1,'09-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettymdljhl940','kohde543n534nj5n3jk45','tarvike523765737656346r3','Pistoke',7,'16-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettynfdsewqewqdlkf4','kohde543n534nj5n3jk45','tarvike52359767569r43r3','Katkaisija',8,'18-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettymdnk43b5h34b54','kohde543n534nj5n3jk45','tarvike52hjn5j34j5n','Pistorasia',7,'21-09-2019');
INSERT INTO ktarvikkeet (ktarviketunnus,kohdetunnus,tarviketunnus,nimi,maara,paivamaara)
values ('kaytettynfdbrwjhbrhb5','kohde543n534nj5n3jk45','tarvikejn54j3k5njk345njk','Sähköjohto',8,'22-09-2019');

INSERT INTO login (id,sposti,salasana) values (1,'esimerkki1@sposti.fi','salis1');
INSERT INTO login (id,sposti,salasana) values (2,'esimerkki2@sposti.fi','salis2');
INSERT INTO login (id,sposti,salasana) values (3,'esimerkki3@sposti.fi','salis3');

