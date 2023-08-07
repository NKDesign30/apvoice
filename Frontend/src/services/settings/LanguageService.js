import { isDevEnvironment } from '@/services/utils';

export default class LanguageService {
  static fallbackLanguage = 'en';

  static fallbackCountry = 'Germany';

  static developmentLanguage = 'de';

  static locationPort = window.location.port;

  static specialDomains = {
    'apovoice.awsm.rocks': 'es',
    'apovoice-es-frontend-stage.azurewebsites.net': 'es',
    'apovoice-frontend-prod.azurewebsites.net': 'es',
    'stage.apovoice.com': 'en',
    'www.apovoice.com': 'en',
  };

  static resolve() {
    if (isDevEnvironment()) {
      switch (LanguageService.locationPort) {
        case '8080':
          return 'de';
        case '8085':
          return 'es';
        case '8090':
          return 'at';
        default:
          return 'de';
      }

      // return LanguageService.developmentLanguage;
    }

    const { hostname } = window.location;

    if (LanguageService.isSpecialDomain(hostname)) {
      return LanguageService.specialDomains[hostname];
    }

    const domainSpecificLanguage = hostname.match(/\.(\w+)$/i);

    if (domainSpecificLanguage !== null) {
      return domainSpecificLanguage[1].toLowerCase();
    }

    return LanguageService.fallbackLanguage;
  }

  static resolveCountry() {
    const { hostname } = window.location;

    if (isDevEnvironment() || LanguageService.isSpecialDomain(hostname)) {
      return LanguageService.fallbackCountry;
    }

    switch (hostname.match(/\.(\w+)$/i)[1]) {
      case 'es':
        return 'Spain';
      case 'de':
        return 'German';
      case 'at':
        return 'Austria';

      default:
        return LanguageService.fallbackCountry;
    }
  }

  static isSpecialDomain(hostname) {
    return Object.keys(LanguageService.specialDomains).indexOf(hostname) !== -1;
  }
}
