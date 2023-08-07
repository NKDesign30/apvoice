# Usermeta keymapping

Wird durch wp_creaet_user() eingetragen:
- nickname
- first_name
- last_name
- description
- richt_editing
- syntax_highlighting
- comment_shortcuts
- admin_color
- use_ssl
- show_admin_bar_front
- locale
- wp_capabilites
- wp_user_level

| INT  | DE  |
|------|-----|
|form_of_address|anrede|
|title|titel|
|first_name|first_name|
|last_name|last_name|
|nickname|nickname|
|job|tatigkeit|
|working_since|experience|
|age|alter| <- verschiedene alters stufen
|priorities|aufgaben| <- der key *aufgaben_custom* muss in priorities reinegmerged werden, es muss ein wert *others* und der wert auf *aufgaben_custom* am ende reingemerged werden
|tasks|schwerpunkte| <- wie bei aufgaben nur mit *schwerpunkte_custom*, in INT gibt es aber kein others
|wp_capabilities|mtjpt_capabilities|
|primary_blog|primary_blog|
|profile_picture|???|
|login_dates|last_login_time| <- muss in array konvertiert werden


## Neue Keys für INT
| DE   | Anmerkungen |
|------|-------------|
|land|muss nicht mit übernommen werden, diese zuteilung passiert über primary_blog|
|pharmacy|Wie wird es bestimmt? keine Auswahlmöglchkeit|
|pharmacy_city|Ort|
|pharmacy_hausnummer|Hausnummer|
|pharmacy_land|Wie wird es bestimmt?|
|pharmacy_name|Name|
|pharmacy_plz|PLZ|
|pharmacy_street|Anschrift|
|pharmacy_type|Wie wird es bestimmt? keine Auswahlmöglchkeit|
|cooperation|Kooperation von Apotheke|

## DE: Fragen zu UserMeta:
- **points_total**: Ich gehe davon aus das dies die punktezahl ist, die ein user ingesamt gesammelt hat, ist das richtig?
- **points_current**: Ich gehe davon aus das dies die aktuelle Punktezahl des Users ist, ist das richtig? 
- **points**: Welchen nutzen beinhaltet dieser key?
- **redeem_used**, **redeem_total**, **redeem**: Bitte diese keys und die zusammengehörigkeit erklären. 
- **activity**: Was genau sagt dieser key aus?
- **mailchimp_sync_3f7171ce2f**, **mc4wp_sync_remote_email_address**, **mc4wp_sync_last_updated**: Ich gehe davon aus das dies identifier für mailchimp sind, ist das richtig? Falls ja, diese müssen exakt übernommen werden, richtig?
- **pharmacy**: Welchen nutzen hat dieser key?
- **pharmacy_type**: Welchen nutzen hat dieser key?
- **pharmacy_land**: Wie wurde das festgelegt? Ich sehe keine Auswahlmöglichkeit im Formular.
- **kompetenz**: Welchen nutzen hat dieser key?


## DE: Allgemeine konzeptionelle Fragen:
- Wie kriegen wir die Apotheken sinnvoll in die INT Apotheken struktur migriert, mit zugehörigen PUN's etc. 
- Was genau ist die **Kundennummer**, bitte um genauere erklärung und zuordnung. 
- Es gibt eine verschiedene anzhl von schwerpunkten von deutschland zu INT, wie wird damit umgegangen?
- Wie gehen wir mit den **expert_codes** um? Hier müssten wir eigentlich im INT Portal die neue struktur adaptieren um die codes aus dem deutschen portal korrekt zu übertragen.

## INT: Allgemein Fragen:
- ist *Job Role* (in registrierung) und *Occupation* nicht das selbe? bzw. soll das selbe sein? Denn *Job Role* kann im profil nicht angepasst werden.

# Training keymapping

## Meta: Training-Series / Produkt

| INT  | DE  |
|------|-----|
|informations_name|preview_title|
|informations_description|preview_text|
|trainings_0_training_id|trainings_0_training_id|
|trainings_0_year|trainings_0_year|

## Meta: Trainings 

| INT  | DE  |
|------|-----|
|lessons_#_lesson_meta_infos_title|training_sections_###_name|
|lessons_#_lesson_meta_infos_sub_title|training_sections_###_data_preview_subtext|
|lessons_#_lesson_meta_infos_description|training_sections_###_data_preview_text|
|lessons_#_lesson_meta_infos_duration_time| training_sections_###_data_preview_time|
|lessons_#_lesson_meta_infos_duration_type| hierfür gibt es keinen deutschen wert, da Min immer an die zeit geschrieben ist, prüfen ob immer Min. gesetzt ist, dann per default typ **min** setzen|
lessons_#_lesson_sections_#_title|training_sections_###_data_training_tabs_#_tab_name|

FÜr INT: die ersten **#**-Placeholder hinter lesson, müssen durch 0, 1, 2 ersett werden. Dies wird wie folgt gemapped:
- Indikation = 0
- Produkt = 1
- Beratung = 2




## DE: Fragen zu Trainings
- Können die Training-Serien aka. Produkte unterschieden werden zwischen Deutschland und Österreich? Ich sehe keinen direkten indikator.
- Wie gehen wir mit der kategorisierung der training serien um? gibt es in deutschland vergleichbare kategorien wie im spanischen portal? müssen neuen kategorien erstellt werden? welche?
- Ländereinstellung: Es kann nur *Alle* oder *Österreich* ausgewählt werden, bedeutet das, dass Trainings prinzipiell entweder für Deutschland UND Österreich ausgespielt werden oder NUR für Österreich? Sprich, es kann keine Trainings geben die NUR für Deutschland ausgespielt werden, ist das so richtig?
- "Soll für diese Länder ausgeblendet werden": Kann der Filter mit dem oberen kombiniert werden? Verstehe nicht ganz wieso ich eine Option zum einschränken von Ländern habe und eine zum ausblenden, bewirken die nicht das gleiche? Oder ist das auf ein extra verhalten zurückzuführen? Die Auswahl mit den Ländern ist die selbe wie oben beschrieben, *Alle* und *Österreich*, dies soll sich dann wahrscheinlich wie oben beschrieben verhalten, richtig? Oder ist hier angedacht, beispielsweise im ersten Filter *Alle* auszuwählen und dann das Training für *Österreich* auszublenden? Dann wäre das Training nur für Deutschland verfügbar. <- weird
- Thema Reporting: wenn ich die trainings in die INT plattform migriere, würde ich auch die ganzen daten mit nehmen die die erstellungs und bearbeitungs datum-daten enthalten. Das post_date welches auch für das Reporting genommen wird um trainigns für einen zeitraum auszuwerden, wäre dann natürlich auf dem erstellten datum der deutschen plattform. wäre das so gewünscht oder soll ein JETZT datum eingetragen werden?
- **Quiz Antworten aus Trainings:** Kann es sein das die Antworten eines einzelnen Quiz gar nicht gespeichert werden, sondern nur die anzahl der beantworteten fragen? In der Tabelle **mtjpt_aav_trainings** werden soweit ich sehe die quiz ergebnisse gespeichert. Hier gibt es ein array für jede section (indication, produckt, beratung). Jede section hat die keys *id, complete* und *question*. Die werte aus id und complete sind völlig klar. Der key question ist meiner meinung nach ein inkrementeller wert für jede beantwortete **Quiz Frage**. Was mir aber völlig unklar ist, ist das wenn ein Quiz nur eine Frage hat und diese beantwortet wird, bleibt der wert für **question** weiter bei 0. Hat ein Quiz mindestens 2 Fragen und es wird die erste beantwortet, steht der wert bei **question** auf 1. Bitte um klärungsbedarf.
Aufgefallen ist mir hierbei, das wenn die letzte Frage eines Quiz beantwortet wird, der wert für **question** nie hochgezählt wird, sondern der **complete** timestamp eingetragen wird. Ist das so gewollt, das bei der letzten Antwort statt question der timestamp eingetragen wird? 


# Survey meta keymapping
| INT  | DE  |
|------|-----|
|duration_time|time_to_pass|
|duration_type|__NOT_AVAILABLE__| <- immer min. eintragen
|points|points|
|__NOT_AVAILABLE__|survey_survey_id| <- Hier wird die survey gespeichert die in dem *modal survey* plugin erstellt wurde




## DE: Infos zu Umfragen

### Modal Survey Plugin:
- Surveys werden in **mtjpt_modal_survey_surveys** gespeichert, spalte **id** hat die survey id, spalte **options** ist nicht relevant. Durch die spalte **owner** könnte der author übertragen werden.
- Fragen der surveys werden in **mtjpt_modal_survey_questions** gespeichert. Relation ist durch **survey_id** herzustellen. in der spalte **question** steht die Frage drin.
- Antwortmöglichkeiten zu den Fragen werden in **mtjpt_modal_survey_answers**. Relation ist durch **survey_id** herzustellen. Jede Antwortmöglichkeit hat einen eigenen eintrag. Durch die **question_id** lässt sich herausfinden welche Antwortmöglichkeiten zusammen hängen. Die Spalte **answer** hält den antwort value. In der Spalte **aoptions** befindet sich ein serialisiertes array mit informationen zu den feld typen. Soweit ich sehen konnte, ist der erste eintrag dieses arrays der Feld typ.
- Feldtypen:
    - Normal Answer = default
    - Open Text Answer = open
    - Numeric Answer = numeric
    - Date Answer = date
    - List Answer = select
- Welchen nutzen hat die ausgeblendete antwort möglichkeit "No" bei einem freigen eingabetext? Dieses pattern ist immer wieder zu sehen. Ich würde es aus meiner sicht beim merge entfernen. 
- Gibt es auf der deutschen plattform in den umfragen fragen die mit einem survey modul der Internationlen plattform **Choice (Multi)** oder **Answer (Multi Line)** vergleichbar sind?




## TODOS:
- Role Mapping: Wie genau werden die rollen aus dem deutschen portal auf das internationale portal gemapped? Müssen neue rollen definiert werden? Eine genaue definition ist hier wichtig. 0
- Mailchimp keys migrieren
- Schwerpunkt Mapper implementieren: Werte müssen in INT keys übersetzt werden.
- Aufgaben Mapper implementieren: Werte müssen in INT keys übersetzt werden.
- Titel Mapper implementieren: Werte müssen in INT keys übersetzt werden.
- Tätigkeit Mapper implementieren: Werte müssen in INT keys übersetzt werden.
- User anhand von **pharmacy_land** lokalisieren
- Trainings anhand von beiden Filtern (Alle, Österreich) lokalisieren