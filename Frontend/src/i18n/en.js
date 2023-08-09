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
    abort: "Abort",
    back: "Back",
    cancel: "Cancel",
    close: "Close",
    continue: "Continue",
    edit: "Edit",
    email: "E-mail",
    emailAddress: "E-mail address",
    expertCode: "Expert Code",
    expertPoints: "{0} Expert Points",
    apoCoins: "ApoCoins",
    finish: "Finish",
    next: "Next",
    participate: "Participate",
    password: "Password",
    passwordPlaceholder: "**********",
    pharmacy: "Pharmacy",
    pun: "Pharmacy Unique Number",
    remove: "Remove",
    restart: "Restart",
    save: "Save",
    show: "Show",
    showMore: "Show more",
    readMore: "- read more…",
    showAll: "Show all",
    submit: "Submit",
    summary: "Summary",
    hello: "Hello, {name}!",
    cookieSettings: "Cookie settings",
    forbiddenPageAccess: "Sorry, you are not allowed to visit this page",
    pharmacySearch: "Look for a pharmacy",
    lookingForPharmacy: "Couldn't find your pharmacy?",
    getInTouch: "Contact us!",
    noResults: "Unfortunately no results",

    fuzzySearch: {
      placeholder: "e.g. zipcode…",
      hint: "Just a hint, if you can't find your Pharmacy, try inserting your zipcode."
    },

    // Time formats
    time: {
      short: {
        seconds: "{amount} Sec.",
        minutes: "{amount} Min.",
        hours: "{amount} Hour."
      },

      full: {
        seconds: "{amount} seconds | {amount} second | {amount} seconds",
        minutes: "{amount} minutes | {amount} minute | {amount} minutes",
        hours: "{amount} hours | {amount} hour | {amount} hours"
      }
    }
  },

  // Site template specific translations
  template: {
    navigation: {
      homepage: "Home",
      logout: "Logout",
      more: "more&nbsp;…",
      downloads: "Downloads",
      knowledgeBase: "Knowledge Base",
      profile: "Profile",
      surveys: "Surveys",

      logo: {
        alt: "apovoice Logo"
      }
    },

    login: {
      expired: "Please reload Page."
    },

    footer: {
      copyright: {
        title: "© The Procter & Gamble Company and affiliates, {date}",
        notice:
          "The products mentioned are marketed by The Procter & Gamble Company and its subsidiaries and have no connection with Merck & Co."
      },

      logo: {
        alt: "Procter & Gamble Logo"
      }
    }
  },

  newsletter: {
    subscribe: "Subscribe",
    decline: "Decline"
  },

  // Survey translations
  surveys: {
    salutation: "Welcome back,",
    section: "Welcome to your survey section.",
    available_title: "Your available surveys",
    available: "Available surveys",
    completed: "Completed surveys",
    surveys: "Your surveys",
    all: "All Surveys",
    expiresAt: "{days} days left",

    messages: {
      questionIsRequired: "Please answer this question",
      noSurveysAvailable: "At the moment there are no available surveys.",
      noEvaluationsAvailable: "At the moment there are no evaluated survey results",
      evaluation: "Evaluation of past surveys",
      availabeEvaluations: "All surveys you have already participated in.",
      statusInfo:
        "You still have <b>{surveys} surveys</b> open, which equals to <b>{points} points</b>",

      success: {
        title: "Congratulations!",
        message: "You successfully participated in the <b>{surveyName}</b> survey."
      }
    },

    headlines: {
      expertPoints: "Expert Points",
      availableSurveys: "Your available surveys"
    },

    buttons: {
      redeem: "Redeem now"
    }
  },

  // Training translations
  trainings: {
    availablePremium: "Your Available Premium Content",
    filter: "Filters",
    welcome: "Welcome,",
    welcome_to: "welcome to",
    knowledge: "knowledge section",
    your: "Your",
    overview_text: "Overview",
    overview_text_sci: "Overview",
    available: "available eTrainings",
    completed: "completed eTrainings",
    available_content: "Your Available Content",
    unlocked: "Your Unlocked Content",
    premium: "Premium Content",
    start: "Start Training",
    download: "Download Certificate",
    unlock: "Unlock content",
    dutyText: "Duty text",
    certificate: "Certificate",
    yourCertificate: "Your certificate",
    yourCertificates: "Your certificate",
    finalSectionName: "Summary & Quiz",

    overview: {
      headline: "Our eTrainings",
      message:
        "With our multimedia eTrainings we want to help you to expand your knowledge on different topics. There are different modules for each, at the end of which a knowledge quiz waits for you. Upon successful completion, you will receive an apovoice certificate. I wish you success!",
      submessage: "",
      activity: "Training activity",
      activityMessage:
        "The better your training activity, the more targeted you can advise your customers.<br>In the graph you can see exactly your activity level."
    },

    messages: {
      questionIsRequired: "This question is required",
      noTrainingsAvailable: "At the moment there are no available trainings."
    },

    buttons: {
      checkAnswer: "Check answer",
      startTraining: "Start eTraining",
      nextTraining: "Next eTraining",
      continueWithLesson: "Continue with {lesson}"
    },

    surveyTeaser: {
      headline: "Your vote counts!",
      message: "Take part in our regular surveys and receive great rewards as a thank you."
    },

    scientificTrainings: {
      teaser: "Please add scientific trainings teaser text"
    },

    scientific: {
      welcome_to_sci: "Let's talk science",
      category: "",
      overview: {
        headline: "Our Scientific Trainings",
        message: "Scientific trainings overview message please add",
        submessage: ""
      },
      leavePopup: {
        popuptitle: "See you soon and Thanks for visiting to Let's Talk Science",
        popupdis: "You will automatically access to the promotional content. Enjoy it!",
        popupbtnstay: "Okay, I stay here",
        popupbtnleave: "Agreed I leave this site"
      },
      enterPopup: {
        popuptitle: "Welcome to Let's Talk Science",
        popupdis:
          "In this section you will find purely scientific content, non-promotional and unrelated to the brand. We hope you enjoy it!",
        continue: "Continue"
      }
    },

    successPage: {
      hint: {
        noTime: "No time right now?",
        readHere: "Read summary here",
        nextTraining: "Start your next eTraining now"
      },

      activatedSurvey: {
        headline: "Congratulations, you have activated the following survey"
      }
    }
  },

  // Summary Go Back Link
  goBackButton: "Back to training",

  // Button for generating Invitation Codes
  sendInvitation: "receive expert-codes",

  // Detailers Job translations
  detailersJob: {
    selectPharmacy: {
      headline: "Select a pharmacy",
      subheadline: "Select a pharmacy by name"
    },

    pharmacyName: "Pharmacy Name",
    noResults: "No matching pharmacies found.",
    lastSavedStep: "Last saved: Step {step}/{totalSteps}",
    isFinished: "Last saved: Finished",

    buttons: {
      lookup: "Look up",
      finish: "Finish",
      start: "Start",
      changePharmacy: "Change to another pharmacy"
    },

    informationalTraining: {
      subheadline: "Choose an answer and we will provide you with the right information material."
    }
  },

  // Downloads translations
  downloads: {
    disclaimer: {
      headline: "Disclaimer:",
      text:
        "P&G Health Germany GmbH stellt dem Nutzer die Materialien im Downloadbereich (Werbemittel sowie Fachinformationen, Gebrauchsinformationen und Pflichttexte) zur Information über Produkte der P&G Health Germany GmbH zur Verfügung. Die Fachinformationen und die Pflichttexte für Fachkreise sind nur zur Information des Nutzers bestimmt und dürfen nicht weiterverbreitet werden.<br><br>Die Nutzung der Materialien ist ausschließlich in der Fassung gestattet, in der sie zum Zeitpunkt der Nutzung im Downloadbereich abrufbar sind. Der Nutzer hat die jeweils aktuelle Fassung zu verwenden.<br><br>Änderungen und Kürzungen der zur Verfügung gestellten Materialien bedürfen der vorherigen Zustimmung von P&G Health Germany GmbH.<br><br>Der Verwender trägt die alleinige Verantwortung für die Rechtmäßigkeit der Verwendung. Dies gilt insbesondere für Aussagen, die sich nicht aus den Materialien selbst ergeben, sofern nicht P&G Health Germany GmbH der Verwendung im konkreten Kontext zugestimmt hat.<br><br>Durch die Nutzung der Materialien erklärt sich der Nutzer einverstanden mit diesen Bedingungen."
    },
    title: "Downloads",
    welcome: "Welcome to download area",
    messages: {
      noDownloadsAvailable: "At the moment there no downloads available for this product."
    },
    wrongpassword: "The password you entered is incorrect.",
    dutyText: "Duty text",
    backToOverview: "back to overview",
    decline: "decline",
    accept: "accept",
    search: "Search...",
    checkAll: "select all",
    bundleDownload: "download selection"
  },

  // Knowledge Base translations
  knowledgeBase: {
    prmDatabase: "PRM Database",
    toDatabase: "To database",
    surveyTeaser: {
      headline: "Your vote counts!",
      message: "Take part in our regular surveys and receive great rewards as a thank you."
    },
    relatedPostsHeadline: "Further interesting news"
  },

  // Raffle translations
  raffle: {
    chooseFile: "Choose file",
    form: {
      firstName: "First name",
      lastName: "Last name",
      pharmacyName: "Pharmacy name",
      pharmacyCountry: "Pharmacy country",
      pharmacyStreet: "Pharmacy street",
      pharmacyStreetNumber: "Pharmacy street no",
      pharmacyZipCode: "Pharmacy ZIP code",
      pharmacyCity: "Pharmacy city"
    },
    participate: "Participate",
    congratulation: "Nice, you are in!",
    expired: "Unfortunately this raffle is expired!",
    maxParticipants: "Unfortunately the max count of participants has been reached!",
    uploadFormat: "Please upload an image or a PDF file."
  },

  // Static page translations
  pages: {
    // Login page
    login: {
      intro:
        "Welcome to apovoice,<br><strong>the exclusive community</strong><br>for professionals in the pharmacy sector.",

      messages: {
        pending: "You're being authenticated…",
        success: "Sign in successful, you're being redirected…"
      },

      form: {
        username: {
          placeholder: "E-mail address",
          title: "E-mail address"
        },

        password: {
          placeholder: "Password",
          title: "Password"
        },

        buttons: {
          register: "Register now",
          signin: "Sign in",
          forgotten: "Forgot password"
        }
      }
    },

    // Registration page
    registration: {
      meta: {
        title: "Registration",
        description: "Register for a new account."
      },

      information: {
        headline: "Where can I find this information?"
      }
    },

    // Thank You Page
    thankYou: {
      meta: {
        title: "Thank you and welcome!"
      },

      headline: "Thank you and welcome!",
      firstParagraph:
        "We are pleased to welcome you to apovoice, the exclusive community for pharmacy professionals!",
      secondParagraph:
        "Start now with the latest eTrainings, take part in surveys and collect valuable Expert Points for great rewards.",
      button: "Log in"
    },

    // Forgot password page
    forgotten: {
      meta: {
        title: "Forgot Password",
        description: "Forgot password"
      }
    },

    // Reset password page
    reset: {
      meta: {
        title: "Reset password",
        description: "Reset your password"
      }
    },

    // User activation page
    userActivation: {
      meta: {
        title: "Account activation"
      },
      headlines: {
        success: "Your account has been activated!",
        failed: "Account already activated."
      },
      firstParagraph: "From now on you are part of apovoice - our exciting platform to join in.",
      secondParagraph:
        "You can start with the first eTrainings immediately and collect valuable expert points with every participation in a survey.",
      thirdParagraph: "Have fun with apovoice!",
      button: "Log in"
    },

    // Profile page
    profile: {
      meta: {
        title: "Your user profile"
      },
      changePicture: "Change picture",
      collectedPremiums: "You already have collected a total of {premiums} premiums.",
      editProfile: "Edit profile",
      noPicture: "Please add a profile picture.",
      pictureCaption: "{name}'s profile picture",
      pleaseAddInformation: "(Please add this information).",
      priorities: "Priorities",
      tasks: "Tasks",
      noTasksOrPriorities: "Please complete this information.",
      tasksAndPriorities: "Your tasks and priorities",
      workingSince: "Working since {date}",
      yearsOld: "{age} Years old",
      yourAccount: "Your account",
      yourExpertPoints: 'Your<br class="tablet:hidden"> Expert Points',
      yourPharmacy: "Your pharmacy | Your pharmacies"
    },

    // Edit profile page
    editProfile: {
      meta: {
        title: "Edit your user profile"
      },
      // General section
      general: {
        form: {
          formOfAddress: {
            label: "Form of address",
            mr: "Mr",
            mrs: "Mrs"
          },

          title: "Title",
          firstname: "Name",
          surname: "Surname",
          job: "Job",
          workingSince: "Working since (Year)",
          age: "Age"
        }
      },

      // Tasks and Priorities section
      tasksAndPriorities: {
        headline: "Your tasks and priorities",
        hint: "Multiple selection possible"
      },

      // Priorities section
      priorities: {
        headline: "Priorities"
      },

      // Tasks section
      tasks: {
        headline: "Tasks"
      },

      // Pharmacies section
      pharmacies: {
        yourPharmacy: "Your Pharmacy | Your pharmacies"
      },

      // Account section
      account: {
        headline: "Your account",
        newEmailAddress: "New E-mail adress",
        confirmNewEmailAddress: "Repeat the new e-mail address",
        newEmailAddressNotification:
          "You will receive an email confirming the new email address. The confirmation link is valid for 48 hours.",
        confirmPassword: "Confirm Password"
      }
    },

    // Welcome page
    welcome: {
      meta: {
        title: {
          inner: "Welcome to Apovoice",
          complement: "User Dashboard"
        }
      },
      surveyTeaser: {
        yourSurveys: "Your Surveys"
      },
      trainingTeaser: {
        yourTrainings: "Your eTrainings"
      }
    },

    // Contact page translations
    contact: {
      meta: {
        title: "Contact",
        description: "Contact"
      },
      thankYou: {
        headline: "Thank you for contacting us!",
        firstParagraph: "We will get back to you as soon as possible.",
        button: "To home page"
      }
    },

    // Redeem page translations
    redeem: {
      meta: {
        title: "Exchange your expert points into vouchers"
      },
      error: {
        text: 'put your message here for "en"'
      },
      noVouchers:
        "At the moment you do not have promotional codes available. If you already have 50 ApoCoins, exchange them to get one.",

      headlines: {
        redeemExpertPoints: "Redeem Expert Points",
        expertPoints: "Expert Points",
        vouchers: "Your Vouchers"
      },

      hint: {
        hasEnoughPoints: "You can redeem <b>50 Expert Points</b> for a voucher for a great reward.",
        hasNotEnoughPoints:
          "You need <b>{points} more Expert Points</b> until you can get a voucher.",
        isPendingState:
          "Nach Überprüfung Deiner Registrierung kannst Du hier Deine Experten-Punkte in Gutscheine einlösen."
      },

      messages: {
        expiresAt: "Expires at {date}",
        noVouchersAvailable: "You currently have no vouchers."
      },

      buttons: {
        use: "Use"
      },

      notifications: {
        success:
          "You have successfully redeemed {points} Expert Points into voucher {voucherCode}.",
        failed: "Oops, something went wront."
      }
    },

    // Survey page translations
    surveys: {
      meta: {
        title: "Surveys"
      }
    },

    // Trainings page translations
    trainings: {
      main: {
        meta: {
          title: "Trainings"
        }
      },

      summary: {
        meta: {
          title: "Trainings summary"
        }
      },

      success: {
        meta: {
          title: "Congratulations, you did it"
        }
      }
    },

    // Detailers Job page translations
    detailersJob: {
      main: {
        meta: {
          title: "Detailers Job"
        }
      },

      informationalTraining: {
        meta: {
          title: "Informational Training"
        }
      }
    }
  },

  // CMS Module translations
  modules: {
    progress: {
      chapter: "Chapter {0}"
    },

    textMediaParagraph: {
      buttons: {
        download: "Download {title}"
      }
    },

    selection: {
      or: "or",
      result: "Result: {0}/{1}",
      note: "Please choose an answer"
    },

    user: {
      trainingActivity: {
        yourTrainingActivity: "Your training activity: {0}%"
      },

      loginActivity: {
        yourLoginActivity: "Your login activity: {0}%"
      }
    },

    shelfDisplay: {
      restart: "Restart Puzzle"
    },

    question: {
      multipleAnswersHint: "(Multiple answers possible)"
    },

    pharmacySummary: {
      workingInAnotherPharmacy: "Are you working in another pharmacy?",
      invalidPun: "Incorrect Pharmacy Unique Number",
      associatedSalesRep: "Associated Sales Rep",

      form: {
        pharmacyName: "Pharmacy name",
        pharmacyCountry: "Pharmacy country",
        pharmacyStreet: "Pharmacy street",
        pharmacyStreetNo: "Pharmacy street no",
        pharmacyZipCode: "Pharmacy zip code",
        pharmacyCity: "Pharmacy city",
        germany: "Germany",
        denmark: "Denmark",
        poland: "Poland",
        czechRepublic: "Czech Republic",
        austria: "Austria",
        switzerland: "Switzerland",
        france: "France",
        luxembourg: "Luxembourg",
        belgium: "Belgium",
        netherlands: "Netherlands"
      },

      buttons: {
        add: "Add",
        addMore: "Add another pharmacy",
        lookup: "Lookup"
      }
    },

    situationalCases: {
      quiz: {
        missingAnswer: "Please choose an answer."
      }
    }
  },

  // Loader messages
  loaders: {
    stage: "Loading Stage…",
    trainingSeries: "Loading Trainings…",
    profile: "Loading Profile…",
    surveys: "Loading Surveys…",
    survey: "Loading Survey…",
    pharmacies: "Loading Pharmacies…",
    informationalTraining: "Loading Informational Training…",
    downloads: "Loading Downloads…",
    knowledgeBase: "Loading Knowledge Base…",
    raffle: "Loading Raffle…",
    content: "Loading Content…",
    form: "Loading form…",
    vouchers: "Loading Vouchers…",
    pagePermissions: "Loading App…",
    yourData: "Loading your data..."
  },

  // General data translation
  data: {
    profile: {
      job: {
        pharmacist: "Pharmacist (owner)",
        pharmacist_assistant: "Pharmacist (employed)",
        pharmacy_assistant_or_technician: "Pharmaceutical technician",
        pharmaceutical_engineer: "Pharmaceutical engineer",
        pharmaceutical_commercial_employee: "Pharmaceutical commercial employee",
        student_pharmaceutical_technician: "Student pharmaceutical technician",
        other: "Other"
      },

      priority: {
        none: "None",
        nutrition: "Nutrition",
        homeopathy: "Homeopathy",
        purchasing: "Purchasing",
        pain: "Pain",
        seniors: "Seniors",
        mother_and_child: "Mother and child",
        vitamins: "Vitamins",
        others: "Others"
      },

      task: {
        consulting: "Consulting",
        purchasing: "Purchasing",
        productmanagement: "Productmanagement",
        others: "Others"
      }
    }
  },

  // Errors messages
  // Key must match the error code from the backend api
  errors: {
    not_enough_points: "You don't have enough Expert Points for this action",
    no_voucher_available: "Oops, that didn't work out. Please contact us",
    too_many_retries: "Too many failed login attempts. Please reset your password.",
    incorrect_password:
      '<strong>ERROR:</strong> El nombre de usuario o la contraseña que ha introducido es incorrecto. <a href="/forgot-password" title="Password Lost and Found">¿Perdió su contraseña?</a>'
  },

  side_down: {
    error_404: {
      headline: "Well,",
      sub_headline: "where are you now?",
      description:
        "This is probably not where you wanted to go.<br>But it‘s no problem, just go back to the previus<br>page or the Hommepage."
    }
  },
  welcome: {
    welcome: "Good Morning",
    nice_day: "Have a nice day!",
    edit_profile: "Edit profile",
    achievments: "Your achievements",
    redeem: "Redeem",
    news: "Your news",
    knowledge: "Knowledge",
    scientific: "scientific eTrainings",
    latest_categories: "Latest category trainings",
    latest_scientific: "Latest Scientific Trainings translate",
    latest_premium: "Latest premium content",
    latest_products: "Latest product trainings",
    surveys: "Your surveys",
    surveys_description: "",
    category_trainings_button: "All category trainings",
    scientific_trainings_button: "All Scientific Trainings translate",
    premium_button: "All premium contents",
    surveys_button: "All surveys"
  },
  redeem: {
    welcome: "Good Morning",
    redeem_title: "Redeem your apoCoins here.",
    your: "Your",
    redeem: "Redeem",
    redeem_button: "redeem now",
    vouchers: "Your vouchers",
    most_recent: "Most recent surveys",
    rewards: "Great rewards are waiting for you"
  },
  level_component: {
    level: "level",
    get_extra_points: "get extra points",
    one_training_left: "one training left",
    trainings_left: "{number} trainings left"
  }
};
