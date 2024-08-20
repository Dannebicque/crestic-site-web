import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['liste']
  static values = {
    url: String,
  }

  connect () {
    // this._loadCategories()
  }

  voirDocuments (event) {
    // add an input field + a button with stimulus action to add a category
    this._loadCategories(event.params.categorie)
  }

  async _loadCategories (categorie) {
    const response = await fetch(this.urlValue + '?categorie=' + categorie)
    this.listeTarget.innerHTML = await response.text()
  }
}
