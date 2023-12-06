jQuery(document).ready(function($) {
  $('#group_filter').change(function() {
      var filterValue = $(this).val();
      var url = window.location.href;
      if (url.indexOf('?') > -1) {
          url += '&group_filter=' + filterValue;
      } else {
          url += '?group_filter=' + filterValue;
      }
      window.location.href = url;
  });
});
