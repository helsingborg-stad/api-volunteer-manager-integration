import axios from 'axios'
import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App'
import { updateURLWith } from '../../util/url-query-params'
import { getValidAccessToken } from '../../volunteer-service/rest/create-rest-context'

const renderVolunteerForm = (elements: HTMLElement[]) => () =>
  [...elements]
    .map((e) => ({
      root: ReactDOM.createRoot(e as HTMLElement),
      volunteerApiUri: e.getAttribute('data-volunteer-api-uri') ?? '',
      labels: JSON.parse(e.getAttribute('data-labels') ?? '{}'),
    }))
    .filter(({ volunteerApiUri }) => volunteerApiUri.length > 0)
    .forEach(({ root, volunteerApiUri, labels }) => {
      root.render(
        <React.StrictMode>
          <App volunteerApiUri={volunteerApiUri} labels={labels} />
        </React.StrictMode>,
      )
    })

const onCloseDialog = (el: HTMLElement) => (e: any) => {
  e.preventDefault()
  updateURLWith({ remove: ['is_authenticated'] }, false)
  axios({
    method: 'get',
    url: `${el.getAttribute('data-sign-out-url')}`,
  }).then(() => window.location.reload())
}

const showDialog = () =>
  [...document.querySelectorAll<HTMLElement>('.js-press-on-dom-loaded')]
    .map((e) => ({
      element: e,
      dialogId: `${e?.dataset?.open}`,
    }))
    .filter(({ dialogId }) => dialogId && dialogId.length > 0)
    .forEach(({ element, dialogId }) => {
      const formElements = () =>
        [...document.querySelectorAll<HTMLElement>(`#${dialogId} .js-volunteer-form`)]
          .filter((e) => e.children.length === 0)
          .filter((e) => (e.getAttribute('data-sign-out-url') ?? '').length > 0)
          .map((e) => {
            e.closest('dialog')?.addEventListener('close', onCloseDialog(e))
            return e
          })

      element.addEventListener('click', renderVolunteerForm(formElements()))
      element.click()
      element.remove()
    })

document.addEventListener('DOMContentLoaded', () => {
  getValidAccessToken()
    .then(showDialog)
    .catch(() => {}) //TODO: handle not authenticated
})
