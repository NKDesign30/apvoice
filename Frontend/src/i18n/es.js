/* eslint-disable quotes */
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
    abort: "Abortar",
    back: "Volver",
    cancel: "Cancelar",
    close: "Cerrar",
    continue: "Seguir",
    edit: "Editar",
    email: "Correo electrónico",
    emailAddress: "Dirección de correo electrónico",
    expertCode: "Código Experto",
    expertPoints: "{0} ApoMonedas",
    apoCoins: "ApoMonedas",
    apoPoints: "ApoPuntos",
    finish: "Terminar",
    next: "Siguiente",
    participate: "Participar",
    password: "Contraseña",
    passwordPlaceholder: "**********",
    pharmacy: "Farmacia",
    pun: "Código de Identificación de la Farmacia",
    remove: "Remover",
    restart: "Reiniciar",
    save: "Guardar",
    show: "Ver",
    showMore: "Ver más",
    readMore: "- aprenda más…",
    showAll: "Ver todos",
    submit: "Enviar",
    summary: "Resumen",
    summary_sci: "Resumen y Descargas",
    hello: "¡Hola, {name}!",
    cookieSettings: "Consentimiento de cookies",
    forbiddenPageAccess: "Lo sentimos, este sitio no es accesible para usted.",
    pharmacySearch: "Busque una farmacia",
    lookingForPharmacy: "¿No pudo encontrar su farmacia?",
    getInTouch: "¡Contáctenos!",
    apoPointsTooltip:
      "Al realizar entrenamientos dentro de la sección de los productos de P&G Health, conseguirás ApoPuntos que podrás canjear en la sección contenido premium por el contenido especial que más te interese dentro de esta sección.",
    apoCoinsTooltip:
      "Obtendrás ApoMonedas cuando realices nuestros estudios de mercado, gracias a las cuales podremos conocer tu opinión sobre temas relevantes dentro de la farmacia. ",
    noResults: "Desafortunadamente no hay resultados",

    fuzzySearch: {
      placeholder: "por ejemplo, código postal…",
      hint:
        "Un pequeño consejo, si no puede encontrar su farmacia de inmediato, intente ingresar el código postal.",
    },

    // Time formats
    time: {
      short: {
        seconds: "{amount} s",
        minutes: "{amount} min",
        hours: "{amount} h",
      },

      full: {
        seconds: "{amount} seconds | {amount} segundo | {amount} segundos",
        minutes: "{amount} minutos | {amount} minuto | {amount} minutos",
        hours: "{amount} horas | {amount} hora | {amount} horas",
      },
    },
  },

  // Site template specific translations
  template: {
    navigation: {
      homepage: "Página de inicio",
      logout: "Cierre de sesión",
      more: "más…",
      downloads: "Descargas",
      knowledgeBase: "Conocimiento+",
      profile: "Perfil",
      surveys: "Encuestas",

      logo: {
        alt: "apovoice Logo",
      },
    },

    login: {
      expired: "Por favor, vuelva a cargar la página..",
    },

    footer: {
      copyright: {
        title: "© The Procter & Gamble Company and affiliates, {date}",
        notice:
          "Los productos mencionados son comercializados por The Procter & Gamble Company y sus subsidiarias y no están relacionados con Merck & Co.",
      },

      logo: {
        alt: "Procter & Gamble Logo",
      },
    },
  },

  newsletter: {
    popup: 'He leído y conozco la política de privacidad.',
    subscribe: "Suscríbete al boletín",
    decline: "disminución",
  },

  // Survey translations
  surveys: {
    salutation: "Bienvenido de nuevo,",
    section: "bienvenido a la",
    section2: "sección de encuestas.",
    available_title: "Sus encuestas disponibles",
    available_title2: "",
    available: "Encuestas disponibles",
    available2: "",
    completed: "Encuestas completadas",
    redeem: "canjear",
    PointsOverview: "ApoMonedas",
    overview_text: "Resumen",
    all: "Todas las Encuestas",
    expiresAt: "quedan {days} días",

    messages: {
      questionIsRequired: "Por favor, responda a esta pregunta",
      noSurveysAvailable: "Por el momento no hay nuevas encuestas en las que puedes participar.",
      noEvaluationsAvailable: "Por el momento no hay resultados evaluados de la encuesta",
      evaluation: "Encuestas anteriores",
      availabeEvaluations:
        "Aquí puedes encontrar todas las encuestas en las que ya has participado.",
      statusInfo:
        "Usted todaví­a tiene <b>{surveys} encuestas</b> abiertas, esto corresponde a <b>{points} puntos</b>",

      success: {
        title: "¡Enhorabuena!",
        message: "Has participado con éxito en la <b>{surveyName}</b> encuesta.",
      },
    },

    headlines: {
      expertPoints: "ApoMonedas",
      availableSurveys: "Tus encuestas disponibles",
    },

    buttons: {
      redeem: "Canjear ahora",
    },
  },

  // Training translations
  trainings: {
    availablePremium: "Contenido premium disponible",
    expensivePremium: "Consigue más ApoPuntos para poder desbloquear estos Contenidos Premium",
    filter: "Filtros",
    welcome: "Bienvenido",
    welcome_to: "Bienvenido a la",
    knowledge: "sección de Conocimiento",
    your: "Tus",
    overview_text: "Resumen",
    overview_text_sci: "Resumen y Descargas",
    available: "eTrainings disponibles",
    completed: "eTrainings completados",
    available_content: "Su contenido disponible",
    unlocked: "Tu contenido desbloqueado",
    unlock: "Desbloquear contenido",
    start: "Iniciar la formación",
    download: "Descargar certificado",
    dutyText: "Mandatorys",
    certificate: "Certificado",
    yourCertificate: "Tu certificado",
    yourCertificates: "Tu certificado",
    finalSectionName: "Resumen y Quiz",
    trainingBack: "Volver",

    productTrainings: {
      headline: "Los productos de P&G Health",
      teaser:
        "En esta sección encontrarás todo el contenido que necesitas para entender y explicar los productos de P&G Health. Recuerda que conocer bien el producto es fundamental para poder dar la mejor recomendación/dispensación a tus clientes.",
    },

    categoryTrainings: {
      headline: "Las categorías de P&G Health en tu farmacia",
      teaser:
        "En esta sección encontrarás contenido que te ayudará a entender el mercado, problemas y pensamiento del consumidor y las mejores técnicas para hacer crecer la categoría en tu farmacia.",
    },

    premiumTrainings: {
      headline: "Contenido Premium",
      teaser:
        "¿Tienes ApoPuntos disponibles? Desbloquea contenido premium para seguir formándote en diferentes campos de interés. Elige el contenido que más te interese y comienza tu próximo entrenamiento.",
    },

    scientificTrainings: {
      teaser:
        "En Hablemos de Ciencia podrá encontrar contenido científico de interés para poder desarrollar mejor su función y entender desde el interior nuestros productos.",
    },

    scientific: {
      welcome_to_sci: "Hablemos de Ciencia.",
      category: "",
      overview: {
        headline: "Hablemos de Ciencia",
        message:
          "En esta sección podrás encontrar contenido científico completamente desvinculado de la marca y de carácter no promocional, que te ayudará a entender mejor la ciencia detrás de nuestros productos y patologías.",
        submessage: "",
      },
      leavePopup: {
        popuptitle: "Esperamos volver a verte pronto.",
        popupdis:
          "Gracias por visitar Hablemos de Ciencia. Será redirigido automáticamente al contenido promocional , disfrútalo!",
        popupbtnstay: "Vale, sigo aqui",
        popupbtnleave: "Entendido, abandono el sitio",
      },
      enterPopup: {
        popuptitle: "Bienvenido a Hablemos de ciencia.",
        popupdis:
          "En esta sección encontrará contenido puramente científico, no promocional y desvinculado de la marca. Esperamos lo disfrutes!",
        continue: "Vale, sigo aqui",
      },
    },

    overview: {
      headline: "Conocimiento",
      message:
        "Con estos contenidos multimedia queremos ayudarte a ampliar tus conocimientos sobre diversos temas de tu día a día en la farmacia. Una vez completados con éxito, recibirá un certificado de Apovoice. ¡Buena suerte!",
      submessage: "",
      activity: "Actividad de entrenamiento",
      activityMessage:
        "Cuanto mejor sea tu actividad de entrenamiento, mejor puedes aconsejar a tus clientes. En el gráfico puedes ver exactamente el nivel de actividad.",
    },

    messages: {
      questionIsRequired: "Esta pregunta es obligatoria",
      noTrainingsAvailable: "Actualmente no hay entrenamientos disponibles.",
    },

    buttons: {
      checkAnswer: "Comprobar la respuesta",
      startTraining: "Empezar el entrenamiento",
      nextTraining: "Siguiente entrenamiento",
      continueWithLesson: "Continuar con {lesson}",
      redeem: "Canjear",
    },

    surveyTeaser: {
      headline: "¡Tu voto cuenta!",
      message:
        "Participa en nuestras encuestas regulares y reciba grandes recompensas como agradecimiento.",
    },

    successPage: {
      hint: {
        noTime: "¿No hay tiempo por el momento?",
        readHere: "Lee el resumen aquí",
        nextTraining: "Comienza tu próximo entrenamiento ahora",
        latestIncompleteT: "Última formación incompleta",
      },

      activatedSurvey: {
        headline: "¡Enhorabuena! Has activado la siguiente encuesta",
      },
    },
  },

  // Summary Go Back Link
  goBackButton: "De vuelta a los entrenamientos",

  // Button for generating Invitation Codes
  sendInvitation: "ver códigos de experto",

  // Detailers Job translations
  detailersJob: {
    selectPharmacy: {
      headline: "Selecciona una farmacia",
      subheadline: "Selecciona una farmacia por nombre",
    },

    pharmacyName: "Nombre de farmacia",
    noResults: "No se han encontrado farmacias que coincidan.",
    lastSavedStep: "La última vez que se grabó: Paso {step}/{totalSteps}",
    isFinished: "La última vez que se grabó: Acabado",

    buttons: {
      lookup: "Buscar",
      finish: "Terminar",
      start: "Empezar",
      changePharmacy: "Cambia a otra farmacia",
    },

    informationalTraining: {
      subheadline:
        "Selecciona una respuesta y le proporcionaremos el material de información adecuado.",
    },
  },

  // Downloads translations
  downloads: {
    disclaimer: {
      headline: "Condiciones:",
      text:
        "Material destinado para profesionales sanitarios, no debe transmitirse a consumidor. PROCTER & GAMBLE ESPAÑA, S.A. pone a disposición del usuario los materiales de la zona de descarga (material publicitario así como información técnica, instrucciones de uso y textos obligatorios) para la información sobre los productos de PROCTER & GAMBLE ESPAÑA, S.A. La información técnica y los textos obligatorios para los círculos especializados sólo tienen por objeto informar al usuario y no pueden ser distribuidos más adelante.<br><br>Los materiales sólo podrán utilizarse en la versión en que estén disponibles en la zona de descarga en el momento de su utilización. El usuario debe utilizar la versión actual.<br><br>Los cambios y abreviaturas de los materiales proporcionados requieren el consentimiento previo de PROCTER & GAMBLE ESPAÑA, S.A.<br><br>El usuario es el único responsable de la legalidad del uso. Esto se aplica en particular a las declaraciones que no se derivan de los propios materiales, a menos que PROCTER & GAMBLE ESPAÑA, S.A. haya aceptado su uso en un contexto específico.<br><br>Al utilizar los materiales, el usuario acepta estos términos y condiciones.",
    },
    title: "Descargas",
    welcome: "Bienvenido a la sección de descargas",
    messages: {
      noDownloadsAvailable: "Actualmente no hay descargas disponibles para este producto.",
    },
    wrongpassword: "La contraseña que ha ingresado es incorrecta.",
    dutyText: "Mandatorys",
    backToOverview: "volver a la vista general",
    decline: "disminución",
    accept: "aceptar",
    search: "Buscando...",
    checkAll: "Seleccionar todo",
    bundleDownload: "Descargar archivos seleccionados",
  },

  // Knowledge Base translations
  knowledgeBase: {
    prmDatabase: "Descargas",
    toDatabase: "Ir",
    surveyTeaser: {
      headline: "¡Tu voto cuenta!",
      message:
        "Participa en nuestras encuestas regulares y reciba grandes recompensas como agradecimiento.",
    },
    relatedPostsHeadline: "Otras noticias interesantes",
  },

  // Raffle translations
  raffle: {
    chooseFile: "Selecciona un fichero",
    form: {
      firstName: "Nombre",
      lastName: "Apellido",
      pharmacyName: "Nombre de farmacia",
      pharmacyCountry: "País de la farmacia",
      pharmacyStreet: "Calle de la farmacia",
      pharmacyStreetNumber: "Número de casa de la farmacia",
      pharmacyZipCode: "Código postal de la farmacia",
      pharmacyCity: "Ciudad de la farmacia",
    },
    participate: "Únete a nosotros.",
    congratulation: "¡Genial, estás en el bote de la lotería!",
    expired: "Esta competencia desafortunadamente ha expirado.",
    maxParticipants: "Lamentablemente, ya se ha alcanzado el número máximo de participantes.",
    uploadFormat: "Please upload an image or a PDF file.",
  },

  // Static page translations
  pages: {
    // Login page
    login: {
      intro:
        "Bienvenido a apovoice,<br><strong>la comunidad</strong><br>para profesionales del sector farmacéutico.",

      messages: {
        pending: "Estás siendo autentificado…",
        success: "Acceso exitoso, estás siendo redirigido…",
      },

      form: {
        username: {
          placeholder: "Correo electrónico",
          title: "Correo electrónico",
        },

        password: {
          placeholder: "Contraseña",
          title: "Contraseña",
        },

        buttons: {
          register: "Regístrate ahora",
          signin: "Acceder",
          forgotten: "Olvidé mi contraseña",
        },
      },
    },

    // Registration page
    registration: {
      meta: {
        title: "Registración",
        description: "Regístrate para obtener una nueva cuenta.",
      },

      information: {
        headline: "¿Dónde puedo encontrar esta información?",
      },

      passwordMask: {
        length: "La contraseña debe tener al menos 9 caracteres.",
        number: "La contraseña debe contener un número.",
        uppercase: "La contraseña debe contener una letra mayúscula.",
        lowercase: "La contraseña debe contener una letra minúscula.",
      },
    },

    // Thank You Page
    thankYou: {
      meta: {
        title: "Muchas gracias por tu registro.",
      },

      headline: "Muchas gracias por tu registro.",
      firstParagraph:
        "Para completar tu registro recibirás un correo electrónico nuestro con la solicitud de confirmación.",
      secondParagraph: "Después puedes usar directamente todas las ofertas de apovoice.",
      button: "A la página de inicio",
    },

    // Forgot password page
    forgotten: {
      meta: {
        title: "Olvidado contraseña",
        description: "Olvidado contraseña",
      },
    },

    // Reset password page
    reset: {
      meta: {
        title: "Restablecer contraseña",
        description: "Restablecer tu contraseña",
      },
    },

    // User activation page
    userActivation: {
      meta: {
        title: "Activación de cuenta",
      },
      headlines: {
        success: "¡Bienvenido!",
        failed: "Tu cuenta ya está activada",
      },
      firstParagraph:
        "A partir de ahora eres parte de Apovoice, nuestra excitante plataforma para unirte.",
      secondParagraph:
        "Puedes empezar con los primeros entrenamientos inmediatamente y recoger valiosos ApoMonedas con cada participación en una encuesta.",
      thirdParagraph: "¡Diviértete con apovoice!",
      button: "Acceder",
    },

    // Profile page
    profile: {
      meta: {
        title: "Tu perfil de usuario",
      },
      changePicture: "Cambiar imagen",
      collectedPremiums: "En total ya has recogido {premiums} recompensas.",
      editProfile: "Editar Perfil",
      noPicture: "Por favor, añade una foto de perfil.",
      pictureCaption: "Foto de Perfil de {name}",
      pleaseAddInformation: "(Por favor, añade esta información.)",
      priorities: "Prioridades",
      tasks: "Tareas",
      noTasksOrPriorities: "Complete esta información.",
      tasksAndPriorities: "Tus tareas y prioridades",
      workingSince: "Empleado desde {date}",
      yearsOld: "{age} años",
      yourAccount: "Tu cuenta",
      yourExpertPoints: 'Tus<br class="tablet:hidden"> ApoMonedas',
      yourPharmacy: "Tu farmacia | Tus farmacias",
    },

    // Edit profile page
    editProfile: {
      meta: {
        title: "Edita tu perfil de usuario",
      },
      // General section
      general: {
        form: {
          formOfAddress: {
            label: "Tratamiento",
            mr: "Sra.",
            mrs: "Sr.",
          },

          title: "Titulo",
          firstname: "Nombre",
          surname: "Apellido",
          job: "Profesión",
          workingSince: "Empleado desde (año)",
          age: "Edad",
        },
      },

      // Tasks and Priorities section
      tasksAndPriorities: {
        headline: "Tus tareas y prioridades",
        hint: "Selección múltiple posible",
      },

      // Priorities section
      priorities: {
        headline: "Prioridades",
      },

      // Tasks section
      tasks: {
        headline: "Tareas",
      },

      // Pharmacies section
      pharmacies: {
        yourPharmacy: "Tu farmacia | Tus farmacias",
      },

      // Account section
      account: {
        headline: "Tu cuenta",
        newEmailAddress: "Nueva dirección de correo electrónico",
        confirmNewEmailAddress: "Repetir nueva dirección de correo electrónico",
        newEmailAddressNotification:
          "Recibirá un correo electrónico confirmando la nueva dirección de correo electrónico. El enlace de confirmación es válido por 48 horas.",
        confirmPassword: "Confirmar contraseña",
      },
    },

    // Welcome page
    welcome: {
      meta: {
        title: {
          inner: "Bienvenido a Apovoice",
          complement: "Panel de usuario",
        },
      },
      surveyTeaser: {
        yourSurveys: "Tus encuestas",
      },
      trainingTeaser: {
        yourTrainings: "Tus entrenamientos",
      },
    },

    // Contact page translations
    contact: {
      meta: {
        title: "Contacto",
        description: "Contacto",
      },
      thankYou: {
        headline: "¡Gracias por contactarnos!",
        firstParagraph: "Nos pondremos en contacto contigo lo antes posible.",
        button: "A la página de inicio",
      },
    },

    // Redeem page translations
    redeem: {
      meta: {
        title: "Intercambia tus ApoMonedass en cupones",
      },
      error: {
        text: "No tiene autorización para canjear puntos",
      },
      noVouchers:
        "Por el momento no tienes códigos promocionales disponibles. Si ya tienes 50 ApoMonedas canjéalas para obtener uno.",

      headlines: {
        redeemExpertPoints: "Canjear ApoMonedas",
        expertPoints: "ApoMonedas",
        vouchers: "Tus códigos promocionales",
      },

      hint: {
        hasEnoughPoints:
          "Puedes canjear <b>50 ApoMonedas</b> en un código promocional para un fantástico bono.",
        hasNotEnoughPoints:
          "Necesitas <b>{points} más ApoMonedas </b> hasta que puedas obtener un código promocional.",
        isPendingState:
          "Después de verificar su registro, puede canjear sus puntos de experto por cupones aquí.",
      },

      messages: {
        expiresAt: "Expira el {date}",
        noVouchersAvailable: "Actualmente no tienes códigos promocionales.",
      },

      buttons: {
        use: "Usar",
      },

      notifications: {
        success:
          "Has canjeado con éxito {points} ApoMonedas en el código promocional {voucherCode}.",
        failed: "Uy, algo salió mal.",
      },
    },

    // Survey page translations
    surveys: {
      meta: {
        title: "Las encuestas",
      },
    },

    // Trainings page translations
    trainings: {
      main: {
        meta: {
          title: "Las Entrenamientos",
        },
      },

      summary: {
        meta: {
          title: "Resumen de entrenamiento",
        },
      },

      success: {
        meta: {
          title: "Felicidades lo hiciste",
        },
      },
    },

    // Detailers Job page translations
    detailersJob: {
      main: {
        meta: {
          title: "Detailers Job",
        },
      },

      informationalTraining: {
        meta: {
          title: "Informational Training",
        },
      },
    },
  },

  // CMS Module translations
  modules: {
    progress: {
      chapter: "Sección {0}",
    },

    textMediaParagraph: {
      buttons: {
        download: "Descargar {title}",
      },
    },

    selection: {
      or: "o",
      result: "Resultado: {0}/{1}",
      note: "Por favor, elija una respuesta",
    },

    user: {
      trainingActivity: {
        yourTrainingActivity: "Tu actividad de entrenamiento: {0}%",
      },

      loginActivity: {
        yourLoginActivity: "Tu actividad de acceso: {0}%",
      },
    },

    shelfDisplay: {
      restart: "Reiniciar el Puzle",
    },

    question: {
      multipleAnswersHint: "(Múltiples respuestas posibles)",
    },

    pharmacySummary: {
      workingInAnotherPharmacy: "¿Trabajas en otra farmacia?",
      invalidPun: "El código de identificación de esta farmacia no es válido.",
      associatedSalesRep: "Código asociado",
      punError: "Pun Error",
      punSucess: "Pun Sucess",
      form: {
        punCode: "Código de identificación de la nueva farmacia",
        pharmacyName: "Nombre de la farmacia",
        pharmacyCountry: "Farmacia del país",
        pharmacyStreet: "La calle de la farmacia",
        pharmacyStreetNo: "Farmacia calle no",
        pharmacyZipCode: "El código postal de la farmacia",
        pharmacyCity: "La ciudad de las farmacias",
        germany: "Alemania",
        denmark: "Dinamarca",
        poland: "Polonia",
        czechRepublic: "República Checa",
        austria: "Austria",
        switzerland: "Suiza",
        france: "Francia",
        luxembourg: "Luxemburgo",
        belgium: "Bélgica",
        netherlands: "Países Bajos",
      },

      buttons: {
        add: "Añadir",
        addMore: "Añadir otra farmacia",
        lookup: "Buscar",
      },
    },

    situationalCases: {
      quiz: {
        missingAnswer: "Por favor, elija una respuesta.",
      },
    },
  },

  // Loader messages
  loaders: {
    stage: "El módulo está cargando…",
    trainingSeries: "Los entrenamientos están cargando…",
    profile: "El perfil está cargando…",
    surveys: "Las encuestas están cargando…",
    survey: "La encuesta está cargando…",
    pharmacies: "Las farmacias están cargando…",
    informationalTraining: "El entrenamiento está cargando…",
    downloads: "Las descargas están cargando…",
    knowledgeBase: "Conocimiento+ está cargando…",
    raffle: "Cargando la lotería…",
    content: "El contenido está cargando…",
    form: "El formulario está cargando…",
    vouchers: "Los códigos promocionales están cargando…",
    pagePermissions: "Aplicación cargando…",
    yourData: "Loading your data...",
  },

  // General data translation
  data: {
    profile: {
      job: {
        pharmacist: "Farmacéutico titular",
        pharmacist_assistant: "Farmacéutico adjunto",
        pharmacy_assistant_or_technician: "Auxiliar o técnico de farmacia ",
        pharmaceutical_engineer: "Ingeniero farmacéutico",
        pharmaceutical_commercial_employee: "Empleado comercial farmacéutico",
        student_pharmaceutical_technician: "Estudiante técnico farmacéutico",
        other: "Otros",
      },

      priority: {
        none: "Nada",
        nutrition: "Nutrición",
        homeopathy: "Homeopatí­a y naturopatí­a",
        purchasing: "Compra",
        pain: "Dolor",
        seniors: "Personas mayores",
        mother_and_child: "Madre e hijo",
        vitamins: "Vitaminas",
        others: "Otros",
      },

      task: {
        consulting: "Servicio al cliente",
        purchasing: "Compra",
        productmanagement: "Gestión de grupos de artí­culos",
        others: "Otros",
      },
    },
  },

  // Errors messages
  // Key must match the error code from the backend api
  errors: {
    not_enough_points: "No tienes suficientes ApoMonedas para esta acción.",
    no_voucher_available: "Uy, eso no funcionó. Póngase en contacto con nosotros",
    too_many_retries:
      "Demasiados intentos fallidos de inicio de sesión. Por favor, cambia tu contraseña.",
    incorrect_password:
      '<strong>ERROR:</strong> El nombre de usuario o la contraseña que has introducido es incorrecto. <a href="/forgot-password" title="Password Lost and Found">¿Has olvidado la contraseña?</a>',
  },

  side_down: {
    error_404: {
      headline: "Bien,",
      sub_headline: "donde has terminado ahora?",
      description:
        "Probablemente no querías ir aquí.<br>Pero si esto no es un problema en absoluto, simplemente regrese a la página anterior<br>o a la página de inicio de una voz..",
    },
  },
  welcome: {
    welcome: "Bienvenido de nuevo",
    nice_day: "que tengas un buen día!",
    edit_profile: "Editar perfil",
    achievments: "Tus logros",
    redeem: "canjear",
    news: "Tus noticias",
    knowledge: "Conocimiento",
    scientific: "scientific eTrainings",
    latest_categories: "Las categorías de P&G Health en tu farmacia",
    latest_scientific: "Último entrenamiento científico",
    latest_premium: "Últimos contenidos Premium",
    latest_products: "Los productos de P&G Health",
    star: " ",
    surveys: "Encuestas",
    surveys_description:
      "Desde P&G Health queremos conocer tu opinión, por eso en este apartado podrás participar en estudios de mercado, gracias a los cuales podrás darnos tu opinión sobre distintos temas de tu día a día en la farmacia.",
    category_trainings_button: "Accede a todos los contenidos de categoría",
    scientific_trainings_button: "Todos los entrenamientos científicos",
    premium_button: "Accede a todos los contenidos Premium",
    product_trainings_button: "Accede a todos los contenidos de los productos de P&G Health",
    surveys_button: "Todas las encuestas",
  },
  redeem: {
    welcome: "Bienvenido",
    redeem_title: "Canjea tus ApoMonedas aquí.",
    your: "Tus",
    redeem: "canjear",
    redeem_button: "canjear ahora",
    vouchers: "Tus códigos promocionales",
    most_recent: "Encuestas más recientes",
    rewards: "Te esperan grandes recompensas",
  },
  level_component: {
    level: "level",
    get_extra_points: "obtener puntos extra",
    one_training_left: "queda un entrenamiento",
    trainings_left: "{number} formaciones que quedan",
  },
};
