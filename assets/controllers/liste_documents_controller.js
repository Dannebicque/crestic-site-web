import { Controller } from '@hotwired/stimulus'

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
  static targets = ['listeDocuments']
  static values = {
    urlListeDocuments: String,
    urlAddDocument: String
  }

  connect () {
    this._loadDocuments()
  }

  async _loadDocuments () {
    const response = await fetch(this.urlListeDocumentsValue)
    this.listeDocumentsTarget.innerHTML = await response.text()
  }

  async deleteDocument (event) {
    event.preventDefault()

    if (!confirm('Voulez-vous vraiment supprimer ce document ?')) {
      return
    }

    const response = await fetch(event.currentTarget.href, {
      method: 'DELETE'
    })
    this._loadDocuments()
  }

  async addDocument (event) {
    event.preventDefault()
    const form = new FormData()
    // form.append('document', document.getElementById('form_photo'))

    //ajouter le fichier de la dropzone avec un id form_photo dans l'objet form
    form.append('document', document.getElementById('form_photo').files[0])

    const response = await fetch(this.urlAddDocumentValue, {
      method: 'POST',
      body: form
    })
    this._loadDocuments()
  }

}
