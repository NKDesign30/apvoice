/**
 * Explanation:
 *
 * --- General Translations
 * Basic translations are just plain strings.
 * Example: 'Some translated phrase'
 *
 *
 * --- Pluralized versions
 * Pluralized translations can offer translations according to a given amount.
 * Each translation is separated by a pipe character ( | ) and refers to either:
 * 1: "none" | "many"
 * 2: "none" | "exactly one" | "more than one"
 * Example: 'No egg | Many eggs'
 * Example: 'No egg | One egg | More than one egg'
 *
 * When displayed, the translation matching a given amount will be displayed.
 * Example: 'No egg | Many eggs' for an amount of 10 -> "Many eggs"
 *
 * There could also be string substitutions in the format {0}, {1} etc. or {named}, {substitutions}:
 * Example: 'No egg | {amount} eggs'
 * Example: 'No egg | One egg | {amount} eggs'
 *
 * NOTE: Substitutions MUST NOT be modified!
 *
 *
 * --- String substitutions
 * Substituted translation contain special placeholder characters like:
 * 1: Numbered -> {0}, {1}, etc.
 * 2: Named    -> {amount}, {count}, etc.
 *
 * The translation will be substituted with variable content when the translation is display.
 * Example: "Hello {name}" -> "Hello Simon"
 *
 *
 * NOTE: Substitutions MUST NOT be modified!
 *
 *
 * --- HTML in translations
 * There are some cases where translations contain HTML tags. This is intended and must be taken
 * into account when editing a translation. However, the HTML is limited to a very basic set to
 * make words appear bold or italic etc. Complex HTML should be handled in a more appropriate way.
 * So be careful when editing translations containing HTML and make sure all tags are closing
 * correctly, otherwise the could have negative impacts on the page layout and might break it.
 *
 * NOTE: Not every translation can contain HTML, since these translation strings are handled
 * in an appropriate way when displayed to prevent XSS attacks. If a translation should contain
 * HTML it must be handled accordingly by the implementing part.
 */

export default {
  // General or often reocurring words and phrases.
  general: {
    abort: 'Abbrechen',
    back: 'Zurück',
    cancel: 'Abbrechen',
    close: 'Schließen',
    continue: 'Weiter',
    edit: 'Bearbeiten',
    email: 'E-Mail',
    emailAddress: 'E-Mail-Adresse',
    expertCode: 'Experten-Code',
    expertPoints: '{0} Expertenpunkte',
    apoCoins: 'Expertenpunkte',
    apoPoints: 'ApoPoints',
    finish: 'Abschließen',
    next: 'Weiter',
    participate: 'Teilnehmen',
    password: 'Passwort',
    passwordPlaceholder: '**********',
    pharmacy: 'Apotheke',
    pun: 'P&G-Kundennummer',
    remove: 'Löschen',
    restart: 'Erneut starten',
    save: 'Speichern',
    show: 'Anzeigen',
    showMore: 'Mehr anzeigen',
    readMore: '- mehr erfahren…',
    showAll: 'Alle anzeigen',
    submit: 'Absenden',
    summary: 'Zusammenfassung',
    hello: 'Hallo {name}!',
    cookieSettings: 'Meine Cookie Auswahl',
    forbiddenPageAccess: 'Tut uns leid, diese Seite ist für Dich nicht zugänglich.',
    pharmacySearch: 'Deine Apotheke suchen',
    lookingForPharmacy: 'Deine Apotheke erscheint nicht in der Auswahl?',
    getInTouch: 'Kontaktiere uns!',
    noResults: 'Leider keine Treffer',
    apoPointsTooltip: 'Nach jedem absolvierten eTraining erhältst Du wertvolle ApoPoints, mit denen Du Dir interessante Premium-Inhalte freischalten kannst',
    apoCoinsTooltip: ' Du sagst uns Deine Meinung und dafür belohnen wir Dich. Als Dankeschön für Dein Mitwirken sammelst Du bei jeder Umfrage Expertenpunkte, die Du in tolle Prämien einlösen kannst.',

    fuzzySearch: {
      placeholder: 'z.B. Postleitzahl…',
      hint: 'Kleiner Tipp, wenn Du Deine Apotheke nicht gleich findest, versuche es über die Eingabe der Postleitzahl.',
    },

    // Time formats
    time: {
      short: {
        seconds: '{amount} s',
        minutes: '{amount} min',
        hours: '{amount} h',
      },

      full: {
        seconds: '{amount} Sekunden | {amount} Sekunde | {amount} Sekunden',
        minutes: '{amount} Minuten | {amount} Minute | {amount} Minuten',
        hours: '{amount} Stunden | {amount} Stunde | {amount} Stunden',
      },
    },
  },

  // Site template specific translations
  template: {
    navigation: {
      homepage: 'Startseite',
      logout: 'Ausloggen',
      more: 'Mehr…',
      downloads: 'Downloads',
      knowledgeBase: 'Wissen+',
      profile: 'Profil',
      surveys: 'Umfragen',

      logo: {
        alt: 'apovoice Logo',
      },
    },

    login: {
      expired: 'Bitte Seite neu laden.',
    },

    footer: {
      copyright: {
        title: '© The Procter & Gamble Company and affiliates, {date}',
        notice: 'Die erwähnten Produkte werden von The Procter & Gamble Company und deren Zweiggesellschaften vermarktet und stehen in keinem Zusammenhang mit Merck & Co.',
      },

      logo: {
        alt: 'Procter & Gamble Logo',
      },
    },
  },

  newsletter: {
    subscribe: 'Newsletter abonnieren',
    decline: 'Ablehnen',
  },

  // Survey translations
  surveys: {
    salutation: 'Willkommen',
    section: 'Viel Spaß mit',
    section2: 'unseren Umfragen.',
    available_title: 'Deine verfügbaren Umfragen',
    available_title2: '',
    available: 'verfügbare Umfragen',
    available2: '',
    completed: 'abgeschlossene Umfragen',
    redeem: 'Einlösen',
    all: 'Alle Umfragen',
    PointsOverview: 'Punkteübersicht',
    overview_text: 'Deine Umfragen',
    expiresAt: 'noch {days} Tage',

    messages: {
      questionIsRequired: 'Bitte beantworte diese Frage.',
      noSurveysAvailable: 'Im Moment gibt es keine neuen Umfragen, an denen Du teilnehmen kannst.',
      noEvaluationsAvailable: 'Im Moment sind keine Umfrageergebnisse vorhanden',
      evaluation: 'Vergangene Umfragen',
      availabeEvaluations: 'Hier findest Du alle Umfragen, an denen Du bereits teilgenommen hast.',
      statusInfo: 'Du hast noch <b>{surveys} Umfragen</b> offen, dies entspricht <b>{points} Punkten</b>',

      success: {
        title: 'Herzlichen Glückwunsch',
        message: 'Du hast erfolgreich an der Umfrage <b>{surveyName}</b> teilgenommen.',
      },
    },

    headlines: {
      expertPoints: 'Punkteübersicht',
      availableSurveys: 'Deine verfügbaren Umfragen',
    },

    buttons: {
      redeem: 'Jetzt einlösen',
    },
  },

  // Training translations
  trainings: {
    availablePremium: 'Premium-Inhalte verfügbar',
    expensivePremium: 'Sammle mehr ApoPoints, um diese Premium-Inhalte freizuschalten',
    filter: 'Filter',
    welcome: 'Willkommen',
    welcome_to: 'Viel Spaß mit',
    knowledge: ' unseren eTrainings',
    your: 'Deine',
    overview_text: 'Deine Trainingsübersicht',
    overview_text_sci: 'Deine Trainingsübersicht',
    available: 'verfügbare eTrainings',
    completed: 'abgeschlossene eTrainings',
    available_content: 'Deine verfügbaren eTrainings',
    unlocked: 'Ihr freigeschalteter Inhalt',
    premium: 'Premium-Inhalt',
    start: 'eTraining starten',
    download: 'Zertifikat herunterladen',
    dutyText: 'Pflichttext',
    certificate: 'Zertifikat',
    yourCertificates: 'Deine Zertifikate',
    yourCertificate: 'Dein apovoice-Zertifikat',
    finalSectionName: 'Zusammenfassung & Quiz',
    premiumText: '',
    trainingBack: 'Zurück',

    categoryTrainings: {
      headline: 'P&G Health Kategorie-eTrainings',
      teaser: 'In diesem Abschnitt findest Du Inhalte, die Dir dabei helfen, den Markt, die Herausforderungen und die Denkweise Deiner Kunden noch besser zu verstehen.',
    },

    productTrainings: {
      headline: 'P&G Health Produkt-eTrainings',
      teaser: 'In diesem Abschnitt findest Du Inhalte rund um die Produkte aus dem Hause P&G Health.',
    },

    premiumTrainings: {
      headline: 'Premium-Inhalt',
      teaser: 'In unserem neuen Premium Bereich stellen wir Dir zukünftig spannende Inhalte wie z.B. Markt-Insights, Analysen und wertvolle Tipps für Deine Apotheke zur Verfügung. Die Premium-Inhalte kannst Du dir mit Deinen gesammelten ApoPoints freischalten.',
    },

    scientificTrainings: {
      teaser: 'Please add scientific trainings teaser text',
    },

    scientific: {
      welcome_to_sci: 'Let\'s talk science',
      category: '',
      overview: {
        headline: 'Our Scientific Trainings',
        message: 'Scientific trainings overview message please add',
        submessage: '',
      },
      leavePopup: {
        popuptitle: 'See you soon and Thanks for visiting to Let\'s Talk Science',
        popupdis: 'You will automatically access to the promotional content. Enjoy it!',
        popupbtnstay: 'Okay, I stay here',
        popupbtnleave: 'Agreed I leave this site',
      },
      enterPopup: {
        popuptitle: 'Welcome to Let\'s Talk Science',
        popupdis: 'In this section you will find purely scientific content, non-promotional and unrelated to the brand. We hope you enjoy it!',
        continue: 'Continue',
      },
    },

    overview: {
      headline: 'Unsere eTrainings',
      message: 'Mit unseren multimedialen eTrainings wollen wir Dir helfen, Dein Wissen zu verschiedenen Themen zu erweitern. Dafür gibt es jeweils unterschiedliche Module, an deren Ende ein Wissens-Quiz auf Dich wartet. Nach erfolgreichem Abschluss erhältst Du ein apovoice-Zertifikat.',
      submessage: '',
      activity: 'Trainingsaktivität',
      activityMessage: 'Je besser Deine Trainingsaktivität, desto gezielter kannst Du Deine Kunden beraten. In der Grafik siehst Du genau deinen Aktivitätsstand.',
    },

    messages: {
      questionIsRequired: 'Diese Frage ist erforderlich',
      noTrainingsAvailable: 'Im Moment sind keine eTrainings verfügbar.',
    },

    buttons: {
      checkAnswer: 'Antwort prüfen',
      startTraining: 'Training starten',
      nextTraining: 'Nächstes Training',
      continueWithLesson: 'Weiter zu {lesson}',
      redeem: 'einlösen',
    },

    surveyTeaser: {
      headline: 'Deine Stimme zählt!',
      message: 'Nimm an unseren regelmäßigen Umfragen teil und erhalte als Dankeschön tolle Prämien.',
    },

    successPage: {
      hint: {
        noTime: 'Gerade keine Zeit?',
        readHere: 'Hier Zusammenfassung lesen',
        nextTraining: 'Zu den eTrainings',
      },

      activatedSurvey: {
        headline: 'Herzlichen Glückwunsch! Du hast die folgende Umfrage freigeschaltet',
      },
    },

  },


  // Summary Go Back Link
  goBackButton: 'Zurück zu den Trainings',

  // Button for generating Invitation Codes
  sendInvitation: 'Experten-Codes erhalten',

  // Detailers Job translations
  detailersJob: {
    selectPharmacy: {
      headline: 'Apotheke auswählen',
      subheadline: 'Nach einer Apotheke suchen',
    },

    pharmacyName: 'Name der Apotheke',
    noResults: 'Es wurden keine passenden Apotheken gefunden',
    lastSavedStep: 'Zuletzt gespeichert: Schritt {step}/{totalSteps}',
    isFinished: 'Zuletzt gespeichert: Abgeschlossen',

    buttons: {
      lookup: 'Nachschlagen',
      finish: 'Abschließen',
      start: 'Starten',
      changePharmacy: 'Zu einer anderen Apotheke wechseln',
    },

    informationalTraining: {
      subheadline: 'Wähle eine Antwort aus und wir stellen Dir das entsprechende Informationsmaterial zur Verfügung.',
    },
  },

  // Downloads translations
  downloads: {
    disclaimer: {
      headline: 'Disclaimer:',
      text: 'P&G Health Germany GmbH stellt dem Nutzer die Materialien im Downloadbereich (Werbemittel sowie Fachinformationen, Gebrauchsinformationen und Pflichttexte) zur Information über Produkte der P&G Health Germany GmbH zur Verfügung. Die Fachinformationen und die Pflichttexte für Fachkreise sind nur zur Information des Nutzers bestimmt und dürfen nicht weiterverbreitet werden.<br><br>Die Nutzung der Materialien ist ausschließlich in der Fassung gestattet, in der sie zum Zeitpunkt der Nutzung im Downloadbereich abrufbar sind. Der Nutzer hat die jeweils aktuelle Fassung zu verwenden.<br><br>Änderungen und Kürzungen der zur Verfügung gestellten Materialien bedürfen der vorherigen Zustimmung von P&G Health Germany GmbH.<br><br>Der Verwender trägt die alleinige Verantwortung für die Rechtmäßigkeit der Verwendung. Dies gilt insbesondere für Aussagen, die sich nicht aus den Materialien selbst ergeben, sofern nicht P&G Health Germany GmbH der Verwendung im konkreten Kontext zugestimmt hat.<br><br>Durch die Nutzung der Materialien erklärt sich der Nutzer einverstanden mit diesen Bedingungen.',
    },
    title: 'Downloads',
    welcome: 'Willkommen im Download-Bereich',
    messages: {
      noDownloadsAvailable: 'Für dieses Produkt sind aktuell keine Downloads vorhanden.',
    },
    wrongpassword: 'Das eingegebene Passwort ist falsch.',
    dutyText: 'Pflichttext',
    backToOverview: 'zurück zur Übersicht',
    decline: 'Nicht zustimmen',
    accept: 'Zustimmen',
    search: 'Suchen...',
    checkAll: 'Alles auswählen',
    bundleDownload: 'Auswahl herunterladen',
  },

  // Knowledge Base translations
  knowledgeBase: {
    prmDatabase: 'PRM Datenbank',
    toDatabase: 'Zur Datenbank',
    surveyTeaser: {
      headline: 'Deine Stimme zählt!',
      message: 'Mach mit bei unseren regelmäßigen Umfragen und erhalte als Dankeschön tolle Prämien.',
    },
    relatedPostsHeadline: 'Weitere interessante News',
  },

  // Raffle translations
  raffle: {
    chooseFile: 'Datei auswählen',
    form: {
      firstName: 'Vorname',
      lastName: 'Nachname',
      pharmacyName: 'Name der Apotheke',
      pharmacyCountry: 'Land der Apotheke',
      pharmacyStreet: 'Straße der Apotheke',
      pharmacyStreetNumber: 'Hausnummer der Apotheke',
      pharmacyZipCode: 'PLZ der Apotheke',
      pharmacyCity: 'Stadt der Apotheke',
    },
    participate: 'Mitmachen',
    congratulation: 'Vielen Dank fürs Mitmachen. Wir wünschen Dir viel Glück!',
    expired: 'Dieses Gewinnspiel ist leider abgelaufen.',
    maxParticipants: 'Die maximale Anzahl der Teilnehmer wurde leider bereits erreicht.',
    uploadFormat: 'Bitte lade ein Bild oder eine PDF-Datei hoch.',
  },

  // Static page translations
  pages: {
  // Login page
    login: {
      intro: 'Herzlich willkommen auf apovoice, <br><strong>der exklusiven Community</strong><br>für Fachkräfte im Apothekenbereich.',

      messages: {
        pending: 'Du wirst authentifiziert…',
        success: 'Login erfolgreich, du wirst weitergeleitet…',
      },

      form: {
        username: {
          placeholder: 'E-Mail',
          title: 'E-Mail',
        },

        password: {
          placeholder: 'Passwort',
          title: 'Passwort',
        },

        buttons: {
          register: 'Jetzt registrieren',
          signin: 'Anmelden',
          forgotten: 'Passwort vergessen',
        },
      },
    },

    // Registration page
    registration: {
      meta: {
        title: 'Registrierung',
        description: 'Einen neuen Account anlegen',
      },

      information: {
        headline: 'Wo finde ich diese Informationen?',
      },

      passwordMask: {
        length: 'Das Passwort muss mindestens 9 Zeichen lang sein.',
        number: 'Das Passwort muss eine Nummer enthalten.',
        uppercase: 'Das Passwort muss einen Großbuchstaben enthalten.',
        lowercase: 'Das Passwort muss einen Kleinbuchstaben enthalten.',
      },
    },

    // Thank You Page
    thankYou: {
      meta: {
        title: 'Vielen Dank für deine Anmeldung.',
      },

      headline: 'Vielen Dank für deine Anmeldung.',
      firstParagraph: 'Um Deine Anmeldung abzuschließen erhältst Du von uns eine E-Mail, mit der Bitte, diese zu bestätigen.',
      secondParagraph: 'Danach kannst Du direkt alle Angebote von apovoice nutzen.',
      button: 'Zur Startseite',
    },

    // Forgot password page
    forgotten: {
      meta: {
        title: 'Passwort vergessen',
        description: 'Passwort vergessen',
      },
    },

    // Reset password page
    reset: {
      meta: {
        title: 'Passwort zurücksetzen',
        description: 'Passwort zurücksetzen',
      },
    },

    // User activation page
    userActivation: {
      meta: {
        title: 'Account Aktivierung',
      },
      headlines: {
        success: 'Herzlich Willkommen.',
        failed: 'Dein Account wurde bereits aktiviert',
      },
      firstParagraph: 'Ab jetzt bist Du Teil von apovoice – unserer spannenden Mitmach-Plattform.',
      secondParagraph: 'Du kannst sofort mit den ersten eTrainings starten und mit jeder Teilnahme an einer Umfrage wertvolle Expertenpunkte sammeln.',
      thirdParagraph: 'Viel Spaß mit apovoice!',
      button: 'Anmelden',
    },


    // User confirm email page
    userConfirmMail: {
      meta: {
        title: 'E-Mail-Adresse bestätigen',
      },
      headlines: {
        success: 'Erfolgreich geändert.',
        failed: 'Dein Link zur Bestätigung ist ungültig.',
      },
      firstParagraph: 'Deine E-Mail-Adresse wurde erfolgreich aktualisiert.',
      secondParagraph: 'Melde dich doch gleich mit deinen Zugangsdaten an, um dein nächstes eTraining zu starten und mit jeder Teilnahme an einer Umfrage kannst Du wertvolle Expertenpunkte sammeln.',
      thirdParagraph: 'Viel Spaß mit apovoice!',
      button: 'Anmelden',
    },

    // Profile page
    profile: {
      meta: {
        title: 'Dein Benutzerprofil',
      },
      changePicture: 'Bild ändern',
      collectedPremiums: 'Insgesamt hast Du bereits {premiums} Prämien gesammelt.',
      editProfile: 'Profil bearbeiten',
      noPicture: 'Bitte füge ein Profilbild hinzu.',
      pictureCaption: 'Profilbild von {name}',
      pleaseAddInformation: '(Bitte ergänze diese Angaben.)',
      priorities: 'Schwerpunkte',
      tasks: 'Aufgaben',
      noTasksOrPriorities: 'Bitte ergänze diese Angaben.',
      tasksAndPriorities: 'Deine Aufgaben und Schwerpunkte',
      workingSince: 'Berufstätig seit {date}',
      yearsOld: '{age} alt',
      yourAccount: 'Dein Account',
      yourExpertPoints: 'Deine<br class="tablet:hidden"> Expertenpunkte',
      yourPharmacy: 'Deine Apotheke | Deine Apotheken',
    },

    // Edit profile page
    editProfile: {
      meta: {
        title: 'Profil bearbeiten',
      },
      // General section
      general: {
        form: {
          formOfAddress: {
            label: 'Anrede',
            mr: 'Frau',
            mrs: 'Herr',
          },

          title: 'Titel',
          firstname: 'Vorname',
          surname: 'Nachname',
          job: 'Tätigkeit',
          workingSince: 'Berufstätig seit (Jahre)',
          age: 'Alter',
        },
      },

      // Tasks and Priorities section
      tasksAndPriorities: {
        headline: 'Deine Aufgaben & Schwerpunkte',
        hint: 'Mehrfachauswahl möglich',
      },

      // Priorities section
      priorities: {
        headline: 'Schwerpunkte',
      },

      // Tasks section
      tasks: {
        headline: 'Aufgaben',
      },

      // Pharmacies section
      pharmacies: {
        yourPharmacy: 'Deine Apotheke | Deine Apotheken',
        punCode: 'Dein puncode',
      },

      // Account section
      account: {
        headline: 'Dein Account',
        newEmailAddress: 'Neue E-Mail-Adresse',
        confirmNewEmailAddress: 'Neue E-Mail-Adresse wiederholen',
        newEmailAddressNotification: 'Sie erhalten eine Email zur Bestätigung der neuen E-Mail-Adresse. Der Bestätigungslink ist 48 Stunden gültig.',
        confirmPassword: 'Passwort bestätigen',
      },
    },

    // Welcome page
    welcome: {
      meta: {
        title: {
          inner: 'Herzlich Willkommen bei apovoice',
          complement: 'Benutzeroberfläche',
        },
      },
      surveyTeaser: {
        yourSurveys: 'Deine Umfragen',
      },
      trainingTeaser: {
        yourTrainings: 'Deine eTrainings',
      },
    },

    // Contact page translations
    contact: {
      meta: {
        title: 'Kontakt',
        description: 'Kontakt',
      },
      thankYou: {
        headline: 'Danke, dass du uns kontaktiert hast!',
        firstParagraph: 'Wir werden uns so schnell wie möglich mit Dir in Verbindung setzen.',
        button: 'Zur Startseite',
      },
    },

    // Redeem page translations
    redeem: {
      meta: {
        title: 'Tausche deine Punkte gegen einen Coupon ein.',
      },
      error: {
        text: 'Du hast keine Berechtigung für das Einlösen der Punkte',
      },
      noVouchers: 'Du hast noch keine Gutscheine.',

      headlines: {
        redeemExpertPoints: 'Expertenpunkte einlösen',
        expertPoints: 'Expertenpunkte',
        vouchers: 'Deine Gutscheine',
      },

      hint: {
        hasEnoughPoints: 'Du kannst <b>50 Experten-Punkte</b> in einen Gutschein für eine tolle Prämie einlösen.',
        hasNotEnoughPoints: 'Du brauchst noch <b>{points} Expertenpunkte </b>, um einen Gutschein zu erhalten.',
        isPendingState: 'Nach Überprüfung Deiner Registrierung kannst Du hier Deine Expertenpunkte in Gutscheine einlösen.',
      },

      messages: {
        expiresAt: 'gültig bis {date}',
        noVouchersAvailable: 'Du hast noch keine Coupons.',
      },

      buttons: {
        use: 'Einlösen',
      },

      notifications: {
        success: 'Du hast erfolgreich {points} Expertenpunkte in den Coupon {voucherCode} eingelöst.',
        failed: 'Hoppla, da ist etwas schief gelaufen.',
      },
    },

    // Survey page translations
    surveys: {
      meta: {
        title: 'Umfragen',
      },
    },

    // Trainings page translations
    trainings: {
      main: {
        meta: {
          title: 'eTrainings',
        },
      },

      summary: {
        meta: {
          title: 'Zusammenfassung',
        },
      },

      success: {
        meta: {
          title: 'Herzlichen Glückwunsch, Du hast es geschafft.',
        },
      },
    },

    // Detailers Job page translations
    detailersJob: {
      main: {
        meta: {
          title: 'Detailers Job',
        },
      },

      informationalTraining: {
        meta: {
          title: 'Informationstraining',
        },
      },
    },
  },

  // CMS Module translations
  modules: {
    progress: {
      chapter: 'Abschnitt {0}',
    },

    textMediaParagraph: {
      buttons: {
        download: '{title} herunterladen',
      },
    },

    selection: {
      or: 'o',
      result: 'Ergebnis: {0}/{1}',
      note: 'Bitte wähle eine Antwort',
    },

    user: {
      trainingActivity: {
        yourTrainingActivity: 'Deine Trainingsaktivität: {0}%',
      },

      loginActivity: {
        yourLoginActivity: 'Deine Zugriffsaktivität: {0}%',
      },
    },

    shelfDisplay: {
      restart: 'Puzzle neu starten',
    },

    question: {
      multipleAnswersHint: '(Mehrfachauswahl möglich)',
    },

    pharmacySummary: {
      workingInAnotherPharmacy: 'Arbeitest Du in einer weiteren Apotheke?',
      invalidPun: 'Diese P&G-Kundennummer ist ungültig.',
      associatedSalesRep: 'Zugehöriger Code',

      form: {
        pharmacyName: 'Name der Apotheke',
        pharmacyCountry: 'Land der Apotheke',
        pharmacyStreet: 'Straße der Apotheke',
        pharmacyStreetNo: 'Hausnummer der Apotheke',
        pharmacyZipCode: 'PLZ der Apotheke',
        pharmacyCity: 'Stadt der Apotheke',
        germany: 'Deutschland',
        denmark: 'Dänemark',
        poland: 'Polen',
        czechRepublic: 'Tschechien',
        austria: 'Österreich',
        switzerland: 'Schweiz',
        france: 'Frankreich',
        luxembourg: 'Luxemburg',
        belgium: 'Belgien',
        netherlands: 'Niederlande',
      },

      buttons: {
        add: 'Hinzufügen',
        addMore: 'Eine weitere Apotheke hinzufügen',
        lookup: 'Nachschlagen',
      },
    },

    situationalCases: {
      quiz: {
        missingAnswer: 'Bitte wähle eine Antwort.',
      },
    },
  },

  // Loader messages
  loaders: {
    stage: 'Bühnen werden geladen…',
    trainingSeries: 'eTrainings werden geladen…',
    profile: 'Profil wird geladen…',
    surveys: 'Umfragen werden geladen…',
    survey: 'Umfrage wird geladen…',
    pharmacies: 'Apotheken werden geladen…',
    informationalTraining: 'eTraining wird geladen…',
    downloads: 'Downloads werden geladen…',
    knowledgeBase: 'Wissen+ wird geladen…',
    raffle: 'Gewinnspiel wird geladen…',
    content: 'Inhalte werden geladen…',
    form: 'Formular wird geladen…',
    vouchers: 'Gutscheine werden geladen…',
    pagePermissions: 'Anwendung wird geladen…',
    yourData: 'Loading your data...',
  },

  // General data translation
  data: {
    profile: {
      job: {
        pharmacist: 'Apotheker/in (Inhaber/-in)',
        pharmacist_assistant: 'Apotheker/-in (angestellt) ',
        pharmacy_assistant_or_technician: 'PTA',
        pharmaceutical_engineer: 'Pharmazie – Ingenieur/-in',
        pharmaceutical_commercial_employee: 'PKA',
        student_pharmaceutical_technician: 'PTA-Schüler/-in ',
        other: 'Sonstiges',
      },

      task: {
        consulting: 'Beratung von Kunden',
        purchasing: 'Einkauf von Arzneimitteln und Medizinprodukten',
        productmanagement: 'Warengruppenmanagement',
        others: 'Sonstiges',
      },

      priority: {
        none: 'Kein Schwerpunkt',
        purchasing: 'Einkauf',
        nutrition: 'Ernährung',
        homeopathy: 'Homöopathie und Naturheilverfahren',
        pain: 'Schmerz',
        seniors: 'Senioren',
        mother_and_child: 'Mutter & Kind',
        vitamins: 'Vitamine',
        others: 'Sonstiges',
      },
    },
  },

  // Errors messages
  // Key must match the error code from the backend api
  errors: {
    not_enough_points: 'Du hast nicht ausreichend Expertenpunkte für diese Handlung.',
    not_available_pending: 'Du hast nicht ausreichend Expertenpunkte für diese Handlung.',
    no_voucher_available: 'Hoppla, das hat nicht funktioniert. Bitte kontaktiere uns.',
    too_many_retries: 'Zu viele fehlgeschlagene Anmeldeversuche. Bitte ändere Dein Passwort.',
    incorrect_password: '<strong>ERROR:</strong> Der von Dir eingegebene Benutzername oder das Passwort ist falsch. <a href="/forgot-password" title="Password Lost and Found">Passwort vergessen?</a>',
  },

  side_down: {
    error_404: {
      headline: 'Nanu,',
      sub_headline: 'wo bist du denn jetzt gelandet?',
      description: 'Hier wolltest du vermutlich nicht hin.<br>Ist aber gar kein Problem, gehe einfach zur vorherigen<br>Seite oder Startseite von apovoice zurück.',
    },
  },
  welcome: {
    welcome: 'Willkommen',
    nice_day: 'Schön, dass Du da bist.',
    edit_profile: 'Profil bearbeiten',
    achievments: 'Deine Erfolge in den Produkt-Kategorien:',
    achievments_Expert: 'Deine Punkteübersicht:',
    redeem: 'Einlösen',
    news: 'Deine Nachrichten',
    knowledge: 'Wissen',
    latest_categories: 'Neueste Kategorie-eTrainings',
    latest_premium: 'Neueste Premium-Inhalte',
    latest_products: 'Unsere neuesten Produkt-eTrainings',
    latest_scientific: 'Latest Scientific Trainings translate',
    product_trainings_button: 'Alle Produkt-eTrainings',
    star: '*Vitamin A, C, D, B6, B12 und Folsäure (B9) und die Mineralstoffe Eisen, Zink und Selen tragen zu einer normalen Funktion des Immunsystems bei.',
    surveys: 'Unsere Umfragen',
    surveys_description: 'Deine Stimme zählt! Nimm an unseren regelmäßigen Umfragen teil und erhalte als Dankeschön tolle Prämien.',
    category_trainings_button: 'Alle Kategorie-eTrainings',
    scientific_trainings_button: 'All Scientific Trainings translate',
    premium_button: 'Alle Premium-Inhalte',
    surveys_button: 'Alle Umfragen',
  },
  redeem: {
    welcome: 'Willkommen',
    redeem_title: 'Löse hier Deine Expertenpunkte ein.',
    your: 'Deine',
    redeem: 'Einlösen',
    redeem_button: 'Jetzt einlösen',
    vouchers: 'Deine Gutscheine',
    most_recent: 'Deine Umfragen',
    rewards: 'Große Belohnungen warten auf Sie',

  },
  level_component: {
    level: 'level',
    get_extra_points: 'Extrapunkte erhalten',
    one_training_left: 'ein Training übrig',
    trainings_left: 'noch {number} Trainingseinheiten übrig',
  },
};
