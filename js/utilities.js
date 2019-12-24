'use strict';

/////////////////////////////////////////////////////////////////////////////////////////
// FONCTIONS                                                                           //
/////////////////////////////////////////////////////////////////////////////////////////

function loadDataFromDomStorage(name)
{
    var jsonData;

    jsonData = window.localStorage.getItem(name);

    return JSON.parse(jsonData);
}

function saveDataToDomStorage(name, data)
{
    var jsonData;

    jsonData = JSON.stringify(data);

    window.localStorage.setItem(name, jsonData);
}
