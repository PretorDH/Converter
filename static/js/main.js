/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 06.01.2019
 * Time: 12:51
 */
(function ($) {
	$(document)
	/* Ajax submit form */
		.on('submit', 'form', function (e) {
			e.preventDefault();
			data = new FormData(this);
			$.ajax({
				url: $(this).attr('action'),
				method: 'POST',
				type: 'POST',
				data: data,
				processData: false,
				contentType: false,
				accept: 'application/json',
			});
		})
		.ajaxStart(function (e, x) {
		})
		/* Ajax response handler */
		.ajaxSuccess(function (e, x) {
			var data = x.responseJSON;
			data.map(function (c) {
				c['target'] && $(c['target']).html(c['content']);
				c['redirect'] && (window.location = c['redirect']);
				c['history'] && window.history.pushState(null, c['title'], c['history'])
			});
		})
		/* Preview content generator */
		.on('change', 'input,textarea', function (e) {
			$item = $('#previewTask .card-body__task [data-target="' + e.target.name + '"]').text(e.target.value);

			e.target.name === 'file_name' && this.files && this.files.length &&
			Array.from(this.files).map(function (file) {
				if (!file.type.match(/image.*/)) return;
				var reader = new FileReader();
				reader.onload = (function (file) {
					return function (e) {
						$item.attr('src', e.target.result).attr('alt', file.name);
					};
				})(file);
				reader.readAsDataURL(file);
			})
		});

	/* Fix input fields with list*/
	let inputMemory = null;
	$(document)
		.on('focus mousedown touchstart', '[list]', e=>{
			inputMemory = inputMemory || $(e.target).val();
			$(e.target).val('');
		})
		.on('select keydown', '[list]', e=>inputMemory = null)
		.on('blur', '[list]', e=>inputMemory && $(e.target).val(inputMemory));
})(jQuery);