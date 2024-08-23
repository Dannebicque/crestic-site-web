import { Controller } from '@hotwired/stimulus'

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

  add_categorie (event) {
    // ajouter un champs input + un bouton avec stimulus action pour ajouter une catégorie
    const html = `<input type="text" name="categorie" class="form-control" placeholder="Ajouter une catégorie">
<button data-action="click->document#save_categorie" class="btn btn-primary mt-1" data-parent="${event.params.parent}">Ajouter</button>`
    this.categoriesTarget.insertAdjacentHTML('beforeend', html)
  }

  async save_categorie (event) {
    console.log(event.currentTarget.dataset)
    const input = event.target.previousElementSibling
    const form = new FormData()
    form.append('categorie', input.value)
    form.append('parent', event.currentTarget.dataset.parent)
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
