/**
 * GoMage LegalPerson Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2017 GoMage (https://www.gomage.com)
 * @author       GoMage
 * @license      https://www.gomage.com/license-agreement/  Single domain license
 * @terms of use https://www.gomage.com/terms-of-use
 * @version      Release: 1.0.0
 * @since        Class available since Release 1.0.0
 */
Validation.add('gm_lp_pc', 'CNP invalid.', function (v, elm) {
    if (Validation.get('IsEmpty').test(v)) return true;

    if (v.length != 13)
        return false;

    var regex = /^([0-9])([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{3})([0-9])$/;
    var patt = new RegExp(regex);
    var matches = patt.exec(v);
    if (!matches)
        return false;

    var sex = matches[1];
    var year = matches[2];
    var month = matches[3];
    var day = matches[4];
    var regionCode = matches[5];
    var ord = matches[6];
    var crc = matches[7];

    if (sex <= 0)
        return false;

    var validateDate = true;
    var yPrefix = "";
    if (sex == 1 || sex == 2)
        yPrefix = "19";
    else if (sex == 3 || sex == 4)
        yPrefix = "18";
    else if (sex == 5 || sex == 6)
        yPrefix = "20";
    else if (sex == 7 || sex == 8 || sex == 9)
        validateDate = false;

    if (month <= 0 || month > 12)
        return false;

    if (day <= 0 || day > 31)
        return false;

    if (validateDate) {
        var testDate = new Date(parseInt(yPrefix + year, 10), parseInt(month, 10) - 1, parseInt(day, 10), 0, 0, 0);

        if ((testDate.getFullYear() != parseInt(yPrefix + year, 10)) || (testDate.getMonth() + 1 != parseInt(month, 10)) || (testDate.getDate() != parseInt(day, 10))) {
            return false;
        } else {
            var today = new Date();
            if (today < testDate) {
                return false;
            }
        }
    }

    var regionsCodes = {
        '01': 'Alba',
        '02': 'Arad',
        '03': 'Argeş',
        '04': 'Bacău',
        '05': 'Bihor',
        '06': 'Bistriţa-Năsăud',
        '07': 'Botoşani',
        '08': 'Braşov',
        '09': 'Brăila',
        '10': 'Buzău',
        '11': 'Caraş-Severin',
        '12': 'Cluj',
        '13': 'Constanţa',
        '14': 'Covasna',
        '15': 'Dâmboviţa',
        '16': 'Dolj',
        '17': 'Galaţi',
        '18': 'Gorj',
        '19': 'Harghita',
        '20': 'Hunedoara',
        '21': 'Ialomiţa',
        '22': 'Iaşi',
        '23': 'Ilfov',
        '24': 'Maramureş',
        '25': 'Mehedinţi',
        '26': 'Mureş',
        '27': 'Neamţ',
        '28': 'Olt',
        '29': 'Prahova',
        '30': 'Satu Mare',
        '31': 'Sălaj',
        '32': 'Sibiu',
        '33': 'Suceava',
        '34': 'Teleorman',
        '35': 'Timiş',
        '36': 'Tulcea',
        '37': 'Vaslui',
        '38': 'Vâlcea',
        '39': 'Vrancea',
        '40': 'Bucureşti',
        '41': 'Bucureşti S.1',
        '42': 'Bucureşti S.2',
        '43': 'Bucureşti S.3',
        '44': 'Bucureşti S.4',
        '45': 'Bucureşti S.5',
        '46': 'Bucureşti S.6',
        '51': 'Călăraşi',
        '52': 'Giurgiu'
    };

    if (regionsCodes[regionCode] == undefined && (parseInt(regionCode) < 47 || parseInt(regionCode) > 50))
        return false;

    if (ord <= 0)
        return false;

    var tk = '279146358279';
    var s = 0;
    for (var i = 0; i < 12; i++)
        s += v.charAt(i) * tk.charAt(i);
    var c = s % 11;
    if (!(c < 10))
        c = 1;

    if (crc != c) {
        return false;
    }

    return true;
});