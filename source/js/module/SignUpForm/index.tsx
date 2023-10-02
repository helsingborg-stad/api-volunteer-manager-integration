import axios from 'axios'
import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App'
import { updateURLWith } from '../../util/url-query-params'
import { getValidAccessToken } from '../../volunteer-service/rest/create-rest-context'

const renderSignUpForm = (elements: HTMLElement[]) => () =>
  [...elements]
    .map((e) => ({
      root: ReactDOM.createRoot(e as HTMLElement),
      volunteerApiUri: e.getAttribute('data-volunteer-api-uri') || '',
      volunteerAppSecret: e.getAttribute('data-volunteer-app-secret') || '',
      labels: JSON.parse(e.getAttribute('data-labels') || '{}'),
      registrationUrl: e.getAttribute('data-registration-url') || '',
      assignmentId: new URLSearchParams(window.location.search).get('sign_up') || '',
      closeDialogHandler: () =>
        e.closest('dialog')?.querySelector<HTMLButtonElement>('button.c-modal__close')?.click(),
    }))
    .filter(
      ({ volunteerApiUri, volunteerAppSecret, assignmentId }) =>
        volunteerApiUri.length > 0 && volunteerAppSecret.length > 0 && assignmentId.length > 0,
    )
    .forEach(
      ({
        root,
        volunteerApiUri,
        volunteerAppSecret,
        assignmentId,
        closeDialogHandler,
        labels,
        registrationUrl,
      }) => {
        root.render(
          <React.StrictMode>
            <App
              assignmentId={assignmentId}
              volunteerApiUri={volunteerApiUri}
              volunteerAppSecret={volunteerAppSecret}
              closeDialog={closeDialogHandler}
              labels={labels}
              registrationUrl={registrationUrl}
            />
          </React.StrictMode>,
        )
      },
    )

const onCloseDialog = (e: HTMLElement) => (event: any) => {
  event.preventDefault()
  updateURLWith({ remove: ['sign_up'] }, false)
  axios({
    method: 'get',
    url: `${e.getAttribute('data-sign-out-url')}`,
  }).then(() => window.location.reload())
}

const showDialog = () =>
  [...document.querySelectorAll<HTMLElement>('.js-show-assignment-sign-up-dialog')]
    .map((e) => ({
      element: e,
      dialogId: `${e?.dataset?.open}`,
    }))
    .filter(({ dialogId }) => dialogId && dialogId.length > 0)
    .forEach(({ element, dialogId }) => {
      const elements = () =>
        [...document.querySelectorAll<HTMLElement>(`#${dialogId} .js-assignment-sign-up`)]
          .filter((e) => e.children.length === 0)
          .filter((e) => (e.getAttribute('data-sign-out-url') ?? '').length > 0)
          .map((e) => {
            e.closest('dialog')?.addEventListener('close', onCloseDialog(e))
            return e
          })

      element.addEventListener('click', renderSignUpForm(elements()))
      element.click()
      element.remove()
    })

document.addEventListener('DOMContentLoaded', () => {
  getValidAccessToken()
    .then(showDialog)
    .catch(() => {}) //TODO: handle not authenticated
})
