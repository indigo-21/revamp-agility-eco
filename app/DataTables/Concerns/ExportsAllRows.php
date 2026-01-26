<?php

namespace App\DataTables\Concerns;

trait ExportsAllRows
{
	protected function exportAllAction(string $button = 'csv'): string
	{
		return <<<JS
function (e, dt, button, config) {
	var self = this;
	var oldStart = dt.settings()[0]._iDisplayStart;

	dt.one('preXhr', function (e, s, data) {
		data.start = 0;
		data.length = 2147483647;

		dt.one('preDraw', function (e, settings) {
			$.fn.dataTable.ext.buttons.${button}Html5.action.call(self, e, dt, button, config);

			dt.one('preXhr', function (e, s, data) {
				settings._iDisplayStart = oldStart;
				data.start = oldStart;
			});

			setTimeout(function () {
				dt.ajax.reload(null, false);
			}, 0);

			return false;
		});
	});

	dt.ajax.reload();
}
JS;
	}
}
