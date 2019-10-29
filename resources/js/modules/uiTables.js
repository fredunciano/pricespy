window.UiTables = {
    init: function(configOverride = {}) {
        /* Initialize Bootstrap Datatables Integration */
        App.datatables();

        let config = {
            pageLength: 10,
            processing: true,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            language: {
                "searchPlaceholder": searchString(),
                "sEmptyTable": emptyTable(),
                "sInfo": getInfo(),
                "sInfoEmpty": getEmpty(),
                "sLoadingRecords": getLoading(),
                "sProcessing": getLoading(),
                "sInfoFiltered": getFiltered(),
            },
        };

        Object.assign(config, configOverride);

        /* Initialize Datatables */
        $('.datatable').dataTable(config);

        /*/!* Select/Deselect all checkboxes in tables *!/
        $('thead input:checkbox').click(function() {
            var checkedStatus   = $(this).prop('checked');
            var table           = $(this).closest('table');

            $('tbody input:checkbox', table).each(function() {
                $(this).prop('checked', checkedStatus);
            });
        });*/
/*
        /!* Table Styles Switcher *!/
        var genTable        = $('#general-table');
        var styleBorders    = $('#style-borders');

        $('#style-default').on('click', function(){
            styleBorders.find('.btn').removeClass('active');
            $(this).addClass('active');

            genTable.removeClass('table-bordered').removeClass('table-borderless');
        });

        $('#style-bordered').on('click', function(){
            styleBorders.find('.btn').removeClass('active');
            $(this).addClass('active');

            genTable.removeClass('table-borderless').addClass('table-bordered');
        });

        $('#style-borderless').on('click', function(){
            styleBorders.find('.btn').removeClass('active');
            $(this).addClass('active');

            genTable.removeClass('table-bordered').addClass('table-borderless');
        });

        $('#style-striped').on('click', function() {
            $(this).toggleClass('active');

            if ($(this).hasClass('active')) {
                genTable.addClass('table-striped');
            } else {
                genTable.removeClass('table-striped');
            }
        });

        $('#style-condensed').on('click', function() {
            $(this).toggleClass('active');

            if ($(this).hasClass('active')) {
                genTable.addClass('table-condensed');
            } else {
                genTable.removeClass('table-condensed');
            }
        });

        $('#style-hover').on('click', function() {
            $(this).toggleClass('active');

            if ($(this).hasClass('active')) {
                genTable.addClass('table-hover');
            } else {
                genTable.removeClass('table-hover');
            }
        });*/
    }
};

function searchString() {
    return envLang === 'en' ? 'Search...' : 'Suchen...';

}

function emptyTable() {
    return envLang === 'en' ? 'No Data Available' : 'Keine Daten vorhanden';
}

function getInfo() {
    return envLang === 'en' ? "Showing _START_ to _END_ of _TOTAL_ entries" : "_START_ bis _END_ von _TOTAL_ Einträgen"
}

function getEmpty() {
    return envLang === 'en' ? "Showing 0 to 0 of 0 entries" : "Zeige 0 bis 0 von 0 Einträgen"
}

function getFiltered() {
    return envLang === 'en' ? " (filtered from _MAX_ total entries) " : "(Gefiltert aus insgesamt _MAX_ Einträgen) "
}

function getLoading() {
    // return envLang === 'en' ? "Loading..." : "Lädt...";
    return '<div class="loader">\n' +
        '                    <svg width="200px" height="200px">\n' +
        '                        <g id="document">\n' +
        '                            <path fill="#EFEADE" d="M120,87.068L108,75H80v50h40V87.068z M120,87.068"/>\n' +
        '                            <path fill="#D6D1BC"\n' +
        '                                  d="M90.741,99.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 C90.333,98,90,98.334,90,98.753C90,99.166,90.333,99.5,90.741,99.5L90.741,99.5z M90.741,99.5"/>\n' +
        '                            <path fill="#D6D1BC"\n' +
        '                                  d="M91.001,93.5h9.998c0.552,0,1.001-0.335,1.001-0.75c0-0.413-0.449-0.75-1.001-0.75h-9.998 C90.45,92,90,92.337,90,92.75C90,93.165,90.45,93.5,91.001,93.5L91.001,93.5z M91.001,93.5"/>\n' +
        '                            <path fill="#D6D1BC" d="M108,75v12h12L108,75z M108,75"/>\n' +
        '                            <path fill="#D6D1BC"\n' +
        '                                  d="M90.741,105.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,105.166,90.333,105.5,90.741,105.5L90.741,105.5z M90.741,105.5"/>\n' +
        '                            <path fill="#D6D1BC"\n' +
        '                                  d="M90.741,111.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,111.166,90.333,111.5,90.741,111.5L90.741,111.5z M90.741,111.5"/>\n' +
        '                            <path fill="#D6D1BC"\n' +
        '                                  d="M90.741,117.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,117.166,90.333,117.5,90.741,117.5L90.741,117.5z M90.741,117.5"/>\n' +
        '                        </g>\n' +
        '                        <g id="search">\n' +
        '                            <path fill="#566181"\n' +
        '                                  d="M127.039,127.787l-13.217-13.213c2.793-2.594,4.555-6.285,4.555-10.385c0-7.821-6.367-14.189-14.188-14.189 C96.37,90,90,96.369,90,104.189c0,7.82,6.37,14.188,14.189,14.188c2.783,0,5.375-0.818,7.57-2.211l13.449,13.451 c0.26,0.246,0.582,0.383,0.924,0.383c0.32,0,0.646-0.137,0.906-0.383C127.545,129.111,127.545,128.291,127.039,127.787z M92.582,104.189c0-6.396,5.211-11.608,11.608-11.608c6.406,0,11.607,5.211,11.607,11.608c0,6.402-5.201,11.607-11.607,11.607 C97.793,115.797,92.582,110.592,92.582,104.189z"/>\n' +
        '                        </g>\n' +
        '                    </svg>\n' +
        '                </div>'
}

// function language() {
//     if (envLang === 'en') {
//         return {
//             "sEmptyTable": "No data available in table",
//             "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
//             "sInfoEmpty": "Showing 0 to 0 of 0 entries",
//             "sInfoFiltered": "(filtered from _MAX_ total entries)",
//             "sInfoPostFix": "",
//             "sInfoThousands": ",",
//             "sLengthMenu": "Show _MENU_ entries",
//             "sLoadingRecords": "Loading...",
//             "sProcessing": "Processing...",
//             "sSearch": "Search:",
//             "sZeroRecords": "No matching records found",
//             "oPaginate": {
//                 "sFirst": "First",
//                 "sLast": "Last",
//                 "sNext": "Next",
//                 "sPrevious": "Previous"
//             },
//             "oAria": {
//                 "sSortAscending": ": activate to sort column ascending",
//                 "sSortDescending": ": activate to sort column descending"
//             }
//         }
//     } else {
//         return {
//             "sEmptyTable": "Keine Daten in der Tabelle vorhanden",
//             "sInfo": "_START_ bis _END_ von _TOTAL_ Einträgen",
//             "sInfoEmpty": "Keine Daten vorhanden",
//             "sInfoFiltered": "(gefiltert von _MAX_ Einträgen)",
//             "sInfoPostFix": "",
//             "sInfoThousands": ".",
//             "sLengthMenu": "_MENU_ Einträge anzeigen",
//             "sLoadingRecords": "Wird geladen ..",
//             "sProcessing": "Bitte warten ..",
//             "sSearch": "Suchen",
//             "sZeroRecords": "Keine Einträge vorhanden",
//             "oPaginate": {
//                 "sFirst": "Erste",
//                 "sPrevious": "Zurück",
//                 "sNext": "Nächste",
//                 "sLast": "Letzte"
//             },
//             "oAria": {
//                 "sSortAscending": ": aktivieren, um Spalte aufsteigend zu sortieren",
//                 "sSortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
//             },
//             "select": {
//                 "rows": {
//                     "_": "%d Zeilen ausgewählt",
//                     "0": "",
//                     "1": "1 Zeile ausgewählt"
//                 }
//             },
//             "buttons": {
//                 "print": "Drucken",
//                 "colvis": "Spalten",
//                 "copy": "Kopieren",
//                 "copyTitle": "In Zwischenablage kopieren",
//                 "copyKeys": "Taste <i>ctrl</i> oder <i>\u2318</i> + <i>C</i> um Tabelle<br>in Zwischenspeicher zu kopieren.<br><br>Um abzubrechen die Nachricht anklicken oder Escape drücken.",
//                 "copySuccess": {
//                     "_": "%d Spalten kopiert",
//                     "1": "1 Spalte kopiert"
//                 }
//             }
//         }
//     }
// }
