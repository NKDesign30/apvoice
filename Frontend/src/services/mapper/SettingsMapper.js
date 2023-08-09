import get from 'lodash/get';

export default class SettingsMapper {
  static mapSettings(data) {
    return {
      frontendUrl: get(data, 'frontend_url', ''),
      formLocations: get(data, 'form_locations', []),
      jobRoles: get(data, 'job_roles', []),
      showVoucher: get(data, 'show_voucher', []),
      headCodeSnippets: get(data, 'head_code_snippets', ''),
      bodyCodeSnippets: get(data, 'body_code_snippets', ''),
      bonagoVoucherUrl: get(data, 'bonago_voucher_url', ''),
      captchaWebsiteKey: get(data, 'captcha_website_key', ''),
      sites: get(data, 'sites', ''),
      newsletterPopover: get(data, 'newsletter_popover', ''),
      newsletterPrivacy: get(data, 'newsletter_privacy', ''),
      invitationCodes: get(data, 'invitation_codes', []),
    };
  }
}
