

/* $.tablesorter.characterEquivalents = {
    'a' : 'á',
    'e' : 'é',
    'o' : 'ó',
    'o' : 'ö',
    'o' : 'ő',
    'u' : 'ü',
    'u' : 'ű',
    'i' : 'í'
  };*/
  
/*  $.tablesorter.characterEquivalents = {
    'a' : '\á',
    'e' : '\é',
    'o' : '\ó\ö\ő',
    'u' : '\ü\ű',
    'i' : '\í'
  };*/
  
  /*
  $.tablesorter.characterEquivalents = {
    'á' : 'a',
    'é' : 'e',
    'ó' : 'o',
    'ö' : 'o',
    'ő' : 'o',
    'ü' : 'u',
    'ű' : 'u',
    'í' : 'i'
  };
*/

$(function () {

    // change maxDigits to 4, if values go > 999
    // or to 5 for values > 9999, etc.
    var maxDigits = 5;

    $.tablesorter.addParser({
        id: "times",
        is: function (s) {
            //return true;	
				
			return /^\d+$/.test(s.replace(":",""));
			//return /\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4}/.test(s);
        },
        format: function (s) {
            // prefix contains leading zeros that are tacked
            var prefix = new Array(maxDigits + 1).join('0'),
                // split time into blocks
                blocks = s.split(/\s*:\s*/),
                len = blocks.length,
                result = [];
            // add values in reverse, so if there is only one block
            // (e.g. "10"), then it would be the time in seconds
            while (len) {
                result.push((prefix + (blocks[--len] || 0)).slice(-maxDigits));
            }
            // reverse the results and join them
            return result.length ? result.reverse().join('') : s;
        },
        type: "text"
    });

	    $.tablesorter.addParser({
        id: "times_all_ido",
        is: function (s) {
            //return true;	
				
			return /^\d+$/.test(s.replace(",",""));
			//return /\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4}/.test(s);
        },
        format: function (s) {
            // prefix contains leading zeros that are tacked
            s=s.replace(",",".");
            // reverse the results and join them
            return  s;
        },
        type: "number"
    });

    /*$('table').tablesorter({
        theme: 'blue',
        headers: {
            2: {
                sorter: 'times'
            }
        }
    });*/
});