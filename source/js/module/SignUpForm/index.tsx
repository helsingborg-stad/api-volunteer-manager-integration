import axios from 'axios'
import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App'

const renderSignUpForm = (elements: HTMLElement[]) => () =>
  [...elements]
    .map((e) => ({
      root: ReactDOM.createRoot(e as HTMLElement),
      volunteerApiUri: e.getAttribute('data-volunteer-api-uri') ?? '',
      volunteerAppSecret: e.getAttribute('data-volunteer-app-secret') ?? '',
      labels: JSON.parse(e.getAttribute('data-labels') ?? '{}'),
    }))
    .filter(
      ({ volunteerApiUri, volunteerAppSecret }) =>
        volunteerApiUri.length > 0 && volunteerAppSecret.length > 0,
    )
    .forEach(({ root, volunteerApiUri, volunteerAppSecret }) => {
      root.render(
        <React.StrictMode>
          <App volunteerApiUri={volunteerApiUri} volunteerAppSecret={volunteerAppSecret} />
        </React.StrictMode>,
      )
    })

const reloadPage = () => {
  const getQueryParams = (url: string): URLSearchParams => new URL(url).searchParams
  const withQueryParams =
    (queryParams: Record<string, string>) =>
    (params: URLSearchParams): URLSearchParams => {
      Object.entries(queryParams).forEach(([key, value]) => {
        params.set(key, value)
      })
      return params
    }

  const filterQueryParams =
    (keyList: string[]) =>
    (params: URLSearchParams): URLSearchParams => {
      keyList.forEach((key) => {
        params.delete(key)
      })
      return params
    }
  const toQueryString = (params: URLSearchParams): string => `?${params.toString()}`

  window.location.href = [
    `${window.location.protocol}//`,
    window.location.host,
    window.location.pathname,
    toQueryString(filterQueryParams(['sign_up'])(getQueryParams(window.location.href))),
  ].join('')
}

const onCloseDialog = (e: HTMLElement) => (event: any) => {
  event.preventDefault()

  axios({
    method: 'get',
    url: `${e.getAttribute('data-sign-out-url')}`,
  }).then(reloadPage)
}

const openDialog = () =>
  [...document.querySelectorAll<HTMLElement>('.js-press-on-dom-loaded')]
    .map((e) => ({
      element: e,
      openDialog: () => e?.click && e.click(),
      dialogId: `${e?.dataset?.open}`,
    }))
    .filter(({ dialogId }) => dialogId && dialogId.length > 0)
    .forEach(({ element, openDialog, dialogId }) => {
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
    })

document.addEventListener('DOMContentLoaded', openDialog)
