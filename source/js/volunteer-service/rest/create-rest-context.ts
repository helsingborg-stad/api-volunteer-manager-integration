import axios from 'axios'
import { VolunteerServiceContextType } from '../VolunteerServiceContext'

const options = {
  method: 'POST',
  url: 'https://modul-test.helsingborg.io/volontar/wp-json/wp/v2/employee',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
    Authorization: 'BASIC dm9sdW50ZWVyZWRpdG9yYWNjb3VudDpUdkozIHVER20gYk9vYyBhUGtYIFBLU2QgZUw3dQ==',
  },
  data: {
    title: 'employee from insomnia',
    status: 'pending',
    email: 'snygglars2@helsingborg.io',
    national_identity_number: '901212-1164',
    first_name: 'Snygg',
    surname: 'Lars',
    '': '',
  },
}

axios
  .request(options)
  .then(function (response) {
    console.log(response.data)
  })
  .catch(function (error) {
    console.error(error)
  })

const post = (uri: string, data: object = {}, headers: object = {}) =>
  axios({
    method: 'post',
    url: `${uri}`,
    data,
    headers,
  })

const tryGetAuthorizationHeaders = async () => {
  const { token } = await window.gdiHost.getAccessToken()
  return token
    ? {
        //Authorization: `Bearer ${token}`,
        'Content-Type': 'application/x-www-form-urlencoded',
        Authorization:
          'BASIC dm9sdW50ZWVyZWRpdG9yYWNjb3VudDpUdkozIHVER20gYk9vYyBhUGtYIFBLU2QgZUw3dQ==',
      }
    : {}
}

export const createRestContext = (uri: string): VolunteerServiceContextType =>
  <VolunteerServiceContextType>{
    getVolunteer: () =>
      tryGetAuthorizationHeaders()
        .then((headers) => post(uri, {}, headers))
        .then((response) => response.data?.data?.me),
    registerVolunteer: (input) =>
      tryGetAuthorizationHeaders()
        .then((headers) =>
          post(
            `${uri}'/employee'`,
            {
              title: 'employee from insomnia',
              status: 'pending',
              email: 'snygglars2@helsingborg.io',
              national_identity_number: '901212-1164',
              first_name: 'Snygg',
              surname: 'Lars',
              '': '',
            },
            headers,
          ),
        )
        .then((response) => response.data?.data?.me),
    registerAssignment: (input) =>
      post(
        `${uri}'/assignment'`,
        {
          title: input.title,
          status: 'draft',
        },
        {
          'Content-Type': 'application/x-www-form-urlencoded',
          Authorization:
            'BASIC dm9sdW50ZWVyZWRpdG9yYWNjb3VudDpUdkozIHVER20gYk9vYyBhUGtYIFBLU2QgZUw3dQ==',
        },
      ).then((response) => response.data?.data?.me),
  }
