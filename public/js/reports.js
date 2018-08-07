//Replace the station numbers with names

function ReplaceStationNumbersWithNames(Id) {
    var replaced = $(Id).html().replace('1','פומנטו');
    $(Id).html(replaced);
    var replaced = $(Id).html().replace('2','ווסטון');
    $(Id).html(replaced);
    var replaced = $(Id).html().replace('3','כלכלה');
    $(Id).html(replaced);
}

//Replace the status numbers(boolean) with text
function ReplaceStatusNumberWithText(status_id) {
    var replaced_status = $(status_id).html().replace('0', 'פתוח');
    $(status_id).html(replaced_status);
    var replaced_status = $(status_id).html().replace('1', 'סגור');
    $(status_id).html(replaced_status);
}