import $ from 'jquery'
global.$ = $;
global.postLink = function(url) {
    let form = $('<form>', {
        method: 'post',
        action: url
    });
    $("body").append(form);

    form.submit();

};

import 'font-awesome/scss/font-awesome.scss'
import 'select2/dist/css/select2.min.css'
import '@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css'
import 'select2/dist/js/select2.full.min'

import 'pdfmake'
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css'
import 'datatables.net-bs4/js/dataTables.bootstrap4.min'
import 'datatables.net-select-bs4/css/select.bootstrap4.min.css'
import 'datatables.net-select-bs4/js/select.bootstrap4.min'
import 'datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'
import 'datatables.net-buttons-bs4/js/buttons.bootstrap4.min'
import 'datatables.net-searchbuilder-bs4/css/searchBuilder.bootstrap4.min.css'
import 'datatables.net-searchbuilder-bs4/js/searchBuilder.bootstrap4.min'
import 'datatables.net-searchpanes-bs4/css/searchPanes.bootstrap4.min.css'
import 'datatables.net-searchpanes-bs4/js/searchPanes.bootstrap4.min'

