;(function($) {
	$(".apo-user-cb-bulk").click(function(){
		$(".apo-user-cb").prop("checked", this.checked);
	});
	$(".apo-user-cb").on("click", function() {
		var unchecked = $(".apo-user-cb:not(:checked)").length;
		$(".apo-user-cb-bulk").prop("checked", !unchecked);
	});
	$(".apo-users-bulk").on("submit", function() {
		var mForm = $(this);
		$(".apo-user-cb:checked").each(function() {
			mForm.append('<input type="hidden" name="user_ids[]" value="' + $(this).val() + '">');
		});
	});
	$(".apo-filter-status").on("change", function() {
		$(this).closest("form").submit();
	});
})(jQuery);