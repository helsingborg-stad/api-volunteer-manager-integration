import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App'

document.addEventListener('DOMContentLoaded', () =>
  [...document.querySelectorAll('.js-volunteer-form')]
    .map((e) => ({
      root: ReactDOM.createRoot(e as HTMLElement),
      /*      aboutMeApiUri: e.getAttribute('data-about-me-api-uri') ?? '',
          labels: JSON.parse(e.getAttribute('data-labels') ?? '{}'),*/
    }))
    /*    .filter(({ aboutMeApiUri }) => aboutMeApiUri.length > 0)*/
    .forEach(({ root }) => {
      root.render(
        <React.StrictMode>
          <App />
        </React.StrictMode>,
      )
    }),
)
