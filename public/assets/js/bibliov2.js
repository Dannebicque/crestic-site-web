var arrayType = {
  'article': '<span style="background-color: #c32b72; " class="hal_picto">&nbsp;</span>',
  'ART': '<span style="background-color: #c32b72; " class="hal_picto">&nbsp;</span>',
  'COMM_SANS_ACTE': '<span style="background-color: #00bb00; " class="hal_picto">&nbsp;</span>',
  'inproceedings': '<span style="background-color: #33c3ba; " class="hal_picto">&nbsp;</span>',
  'COMM': '<span style="background-color: #196ca3; " class="hal_picto">&nbsp;</span>',
  'COUV': '<span style="background-color: #ef942d; " class="hal_picto">&nbsp;</span>',
  'OUV': '<span style="background-color: #33c3ba; " class="hal_picto">&nbsp;</span>',
  'phdthesis': '<span style="background-color: #f8c91f; " class="hal_picto">&nbsp;</span>',
  'UNDEFINED': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'unpublished': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'IMG': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'OTHER': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'incollection': '<span style="background-color: #33c3ba; " class="hal_picto">&nbsp;</span>',
  'book': '<span style="background-color: #33c3ba; " class="hal_picto">&nbsp;</span>',
  'misc': '<span style="background-color: #7788AA; " class="hal_picto">&nbsp;</span>',
  'MEM': '<span style="background-color: #7788AA; " class="hal_picto">&nbsp;</span>',
  'DOUV': '<span style="background-color: #33c3ba; " class="hal_picto">&nbsp;</span>',
  'POSTER': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'THESE': '<span style="background-color: #f8c91f; " class="hal_picto">&nbsp;</span>',
  'HDR': '<span style="background-color: #f8c91f; " class="hal_picto">&nbsp;</span>',
  'PATENT': '<span style="background-color: #F2FAA7; " class="hal_picto">&nbsp;</span>',
  'ISSUE': '<span style="background-color: #33c3ba; " class="hal_picto">&nbsp;</span>',
  'PROCEEDINGS': '<span style="background-color: #33c3ba; " class="hal_picto">&nbsp;</span>',
  'VIDEO': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'PRESCONF': '<span style="background-color: #33c3ba; " class="hal_picto">&nbsp;</span>',
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
  'REPORT_DOCT': '<span style="background-color: #f8c91f; " class="hal_picto">&nbsp;</span>',
  'REPORT_FORM': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'MINUTES': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'REPORT_COOR': '<span style="background-color: #7788AA; " class="hal_picto">&nbsp;</span>',
  'REPORT_LPRO': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>',
  'REPORT_MAST': '<span style="background-color: darkgray; " class="hal_picto">&nbsp;</span>'
}

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
  if (Array.isArray($ref.title_s)) {

    var $idLang = $ref.language_s.indexOf($locale)
    if ($idLang === -1) {
      var $title = $ref.title_s[0];
    } else {
      var $title = $ref.title_s[$idLang];
    }

  } else {
    var $title = $ref.title_s;
  }
  ref = ref + '<a href="' + $ref.uri_s + '" target="_blank" title="Accéder à la référence sur HAL">' + $title + '</a>. ';

  if ($ref.docType_s === 'COMM')  {
    //conférence
    // if ($ref.bookTitle_s) {
    //   ref = ref + $ref.bookTitle_s
    // }

    if ($ref.conferenceTitle_s) {
      ref = ref + $ref.conferenceTitle_s
    }

    if ($ref.page_s) {
      ref = ref +', pp. ' + $ref.page_s + ', '
    }
  }

  if ($ref.docType_s === 'DOUV' || $ref.docType_s === 'OUV' || $ref.docType_s === 'COUV')  {
    //conférence
    if ($ref.bookTitle_s) {
      ref = ref + $ref.bookTitle_s
    }
    if ($ref.docType_s === 'COUV')
    {
      if ($ref.page_s) {
        ref = ref +', pp. ' + $ref.page_s + ', '
      }
    }
  }

  if ($ref.docType_s === 'POSTER')  {
    //conférence
    if ($ref.conferenceTitle_s) {
      ref = ref + $ref.conferenceTitle_s + '. '
    }
  }

  if ($ref.docType_s === 'ART')  {
    //revue
    if ($ref.journalTitle_s) {
      ref = ref + $ref.journalTitle_s
    }

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

  if ($ref.docType_s === 'THESE' || $ref.docType_s === 'HDR') {
    ref = ref + $ref.authorityInstitution_s + '. ';
  }

  ref = ref + ' ' + $ref.producedDateY_i + '. ';
  if ($ref.doiId_s) {
    ref = ref + ' <a href="https://www.doi.org/' + $ref.doiId_s + '" target="_blank">'+$ref.doiId_s+'</a>';
  }
  return ref;
}
