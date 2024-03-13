function xmlParse(data){
  var references = []
  $(data).find('biblFull').each( function(){
    //chaque référence
    var reference = []
    reference.auteurs = []
    $(this).find('titleStmt').each( function(){
      $(this).find('title').each( function(){
        reference.titre = $(this).html()
      });
      $(this).find('author').each( function(){
        var auteur = []
        auteur.prenom = $(this).find('forename').html()
        auteur.nom = $(this).find('surname').html()
        reference.auteurs.push(auteur)
      });
    });
    references.push(reference)
  });



  // for(var i = 0; i< data.childNodes.length; i++){
  //   var reference = []
  //   var $elt = data.childNodes[i].getElementsByTagName('titleStmt')[0]
  //   console.log($elt.getElementsByTagName('title').innerHTML)
  //   reference.titre = $elt.getElementsByTagName('title').innerHTML
  //   reference.auteurs = []
  //   for(var j = 0; j< $elt.childNodes.length; j++) {
  //     if ($elt.childNodes[j] === 'author') {
  //       console.log($elt.childNodes[j])
  //       auteur.prenom = $elt.childNodes[j].getElementsByTagName('forename').text()
  //       auteur.nom = $elt.childNodes[j].getElementsByTagName('surname').text()
  //       reference.auteurs.push(auteur)
  //     }
  //   }
  //
  //   references.push(reference)
  // }
  //
  console.log(references)
  return references;
}
