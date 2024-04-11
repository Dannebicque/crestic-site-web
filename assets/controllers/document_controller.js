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
  static targets = ['documents', 'categories']
  static values = {
    url: String,
    urlCategories: String
  }

  connect () {
    console.log(this.urlCategoriesValue)
    this._loadCategories()
  }

  add_categorie () {
    // ajouter un champs input + un bouton avec stimulus action pour ajouter une catégorie
    const html = `<input type="text" name="categorie" class="form-control" placeholder="Ajouter une catégorie">
<button data-action="click->document#save_categorie" class="btn btn-primary mt-1">Ajouter</button>`
    this.categoriesTarget.insertAdjacentHTML('beforeend', html)
  }

  async save_categorie (event) {
    const input = event.target.previousElementSibling
    const form = new FormData()
    form.append('categorie', input.value)
    const response = await fetch(this.urlCategoriesValue, {
      method: 'POST',
      body: form
    })
    this.categoriesTarget.innerHTML = await response.text()
  }

  async changeCategorie (event) {
    const response = await fetch(this.urlValue + '?categorie=' + event.params.id)
    this.documentsTarget.innerHTML = await response.text()
  }

  async _loadCategories () {
    const response = await fetch(this.urlCategoriesValue)
    this.categoriesTarget.innerHTML = await response.text()
  }
}
