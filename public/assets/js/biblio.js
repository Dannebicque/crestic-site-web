var arrayType = {
  'article': '<span style="background-color: #c32b72; " class="hal_picto">&nbsp;</span>',
  'ART': '<span style="background-color: #c32b72; " class="hal_picto">&nbsp;</span>',
  'inproceedings': '<span style="background-color: #196ca3; " class="hal_picto">&nbsp;</span>',
  'COMM': '<span style="background-color: #196ca3; " class="hal_picto">&nbsp;</span>',
  'COUV': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'phdthesis': '<span style="background-color: #817FB2; " class="hal_picto">&nbsp;</span>',
  'UNDEFINED': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'unpublished': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'IMG': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'OTHER': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'incollection': '<span style="background-color: #FA7100"; " class="hal_picto">&nbsp;</span>',
  'book': '<span style="background-color: #FA7100"; " class="hal_picto">&nbsp;</span>',
  'misc': '<span style="background-color: #7788AA; " class="hal_picto">&nbsp;</span>',
  'MEM': '<span style="background-color: #7788AA; " class="hal_picto">&nbsp;</span>',
  'DOUV': '<span style="background-color: #FA7100; " class="hal_picto">&nbsp;</span>',
  'POSTER': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'THESE': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'HDR': '<span style="background-color: #817FB2; " class="hal_picto">&nbsp;</span>',
  'PATENT': '<span style="background-color: #F2FAA7; " class="hal_picto">&nbsp;</span>',
  'VIDEO': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'PRESCONF': '<span style="background-color: #196ca3; " class="hal_picto">&nbsp;</span>',
  'MAP': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'NOTE': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'OTHERREPORT': '<span style="background-color: #7788AA; " class="hal_picto">&nbsp;</span>',
  'SON': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'SYNTHESE': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'REPACT': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'SOFTWARE': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'REPORT_ETAB': '<span style="background-color: #7788AA; " class="hal_picto">&nbsp;</span>',
  'REPORT_LABO': '<span style="background-color: #7788AA; " class="hal_picto">&nbsp;</span>',
  'REPORT_LICE': '<span style="background-color: #7788AA; " class="hal_picto">&nbsp;</span>',
  'REPORT_DOCT': '<span style="background-color: #817FB2; " class="hal_picto">&nbsp;</span>',
  'REPORT_FORM': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'MINUTES': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'REPORT_COOR': '<span style="background-color: #7788AA; " class="hal_picto">&nbsp;</span>',
  'REPORT_LPRO': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'REPORT_MAST': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>'
}

// function convertCarBibTexToHtml($str) {
//   if ($str[0] == '{')
//   {
//     $str = $str.substring(1, $str.length)
//   }
//
//   if ($str[$str.length-1] == '}')
//   {
//     $str = $str.substring(0, $str.length-1)
//   }
//
//   return $str.replace(/{\\oe}/g, 'oe').replace(/{\\\'e}/g, 'é').replace(/{\\\"e}/g, 'ë').replace(/{\\\'E}/g, 'É').replace(/{\\\"E}/g, 'Ë').replace(/{\\textdegree}/g,'°').replace(/{\\\'i}/g,'í').replace(/{\\\'a}/g,'á').replace(/{\\`e}/g,'è').replace(/{\\`E}/g,'È').replace(/{\\`a}/g,'à').replace(/{\\\^o}/g,'ô').replace(/{\\\^e}/g,'ê').replace(/{\\\^a}/g,'â').replace(/{\\\^i}/g, 'î').replace(/{\\`i}/g,'ì').replace(/{\\c c}/g,'ç').replace(/{\\"i}/g,'ï');
// }

function capitalize(string) {
  return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

function convertToHtml ($ref) {
  var ref = '';
  //auteurs
  var $auteurs = $ref.authFullName_s
  var $nbAuteurs = $auteurs.length
  for (var i = 0; i < $nbAuteurs; i++) {
      ref = ref + $auteurs[i];

    if (i < $nbAuteurs - 1) {
      ref = ref + ', ';
    }
  }

  ref = ref + '. ';

  //titre
  var $title = $ref.title_s;
  ref = ref + '<a href="' + $ref.uri_s + '" target="_blank" title="Accéder à la référence sur HAL">' + $title + '</a>. ';

  if ($ref.docType_s === 'COMM')  {
    //conférence
    if ($ref.bookTitle_s) {
      ref = ref + $ref.bookTitle_s
    }

    if ($ref.conferenceTitle_s) {
      ref = ref + $ref.conferenceTitle_s
    }

    if ($ref.page_s) {
      ref = ref +', pp. ' + $ref.page_s + ', '
    }
  }

  if ($ref.docType_s === 'DOUV')  {
    //conférence
    ref = ref + $ref.bookTitle_s
    if ($ref.page_s) {
      ref = ref +', pp. ' + $ref.page_s + ', '
    }
  }

  if ($ref.docType_s === 'ART')  {
    //revue
    ref = ref + $ref.journalTitle_s


    if ($ref.volume_s) {
      ref = ref + ', ' + $ref.volume_s;
    }

    if ($ref.issue_s) {
      ref = ref + '('+$ref.issue_s+')';
    }

    if ($ref.page_s) {
      ref = ref + ':' + $ref.page_s + ', ';
    }
  }

  ref = ref + ' ' + $ref.producedDateY_i + '. ';
  if ($ref.doiId_s) {
    ref = ref + ' <a href="https://www.doi.org/' + $ref.doiId_s + '" target="_blank">'+$ref.doiId_s+'</a>';
  }
  return ref;
}


// function convertToHtml ($ref) {
//   var ref = '';
//   //auteurs
//   var $auteurs = convertCarBibTexToHtml($ref.entryTags.AUTHOR).split(' and ');
//   var $nbAuteurs = $auteurs.length;
//   for (var i = 0; i < $nbAuteurs; i++) {
//     var $aut = $auteurs[i].split(',');
//     if ($aut.length === 2) {
//       ref = ref + capitalize($aut[1].trim()) + ' ' + capitalize($aut[0].trim());
//     }
//     if (i < $nbAuteurs - 1) {
//       ref = ref + ', ';
//     }
//   }
//
//   ref = ref + '. ';
//
//   //titre
//   var $title = convertCarBibTexToHtml($ref.entryTags.TITLE);
//   ref = ref + '<a href="' + $ref.entryTags.URL + '" target="_blank" title="Accéder à la référence sur HAL">' + $title + '</a>. ';
//
//   if ($ref.entryType == 'inproceedings')  {
//     //conférence
//     if ($ref.entryTags.BOOKTITLE) {
//       ref = ref + convertCarBibTexToHtml($ref.entryTags.BOOKTITLE);
//     }
//     if ($ref.entryTags.PAGES) {
//       ref = ref +', pp. ' + $ref.entryTags.PAGES + ', ';
//     }
//   }
//
//   if ($ref.entryType == 'incollection')  {
//     //conférence
//     ref = ref + convertCarBibTexToHtml($ref.entryTags.BOOKTITLE);
//     if ($ref.entryTags.PAGES) {
//       ref = ref +', pp. ' + $ref.entryTags.PAGES + ', ';
//     }
//   }
//
//   if ($ref.entryType == 'article')  {
//     //revue
//     ref = ref + convertCarBibTexToHtml($ref.entryTags.JOURNAL);
//
//
//     if ($ref.entryTags.VOLUME) {
//       ref = ref + ', ' + $ref.entryTags.VOLUME;
//     }
//
//     if ($ref.entryTags.NUMBER) {
//       ref = ref + '('+$ref.entryTags.NUMBER+')';
//     }
//
//     if ($ref.entryTags.PAGES) {
//       ref = ref + ':' + $ref.entryTags.PAGES + ', ';
//     }
//   }
//
//   ref = ref + ' ' + $ref.entryTags.YEAR + '. ';
//   if ($ref.entryTags.DOI) {
//     ref = ref + ' <a href="https://www.doi.org/' + $ref.entryTags.DOI.replace(/\\_/g,'_') + '" target="_blank">' + $ref.entryTags.DOI.replace(/\\_/g,'_') + '</a>';
//   }
//   return ref;
// }
