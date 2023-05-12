import axios from 'axios'
import { VolunteerServiceContextType } from '../VolunteerServiceContext'

const post = (uri: string, data: object = {}, headers: object = {}) =>
  axios({
    method: 'post',
    url: `${uri}`,
    data,
    headers,
  })

const get = (uri: string, data: object = {}, headers: object = {}) =>
  axios({
    method: 'get',
    url: `${uri}`,
    data,
    headers,
  })

const tryGetAccessToken = async () => window.gdiHost.getAccessToken()
const getValidAccessToken = async () =>
  tryGetAccessToken().then((r) => {
    console.log(r)
    if (!r?.token || r.token.length === 0) throw new Error('Invalid access token')
    return r
  })
const createAuthorizationHeadersFromToken = (token: string) => ({
  'Content-Type': 'application/x-www-form-urlencoded',
  Authorization: `Bearer ${token}`,
})

const createAuthorizationHeadersFromBase64Secret = (base64Secret: string) => ({
  'Content-Type': 'application/x-www-form-urlencoded',
  Authorization: `BASIC ${base64Secret}`,
})

export const createRestContext = (uri: string): VolunteerServiceContextType =>
  <VolunteerServiceContextType>{
    getVolunteer: () =>
      getValidAccessToken().then(async ({ token, decoded }) => {
        try {
          const { data } = await get(
            `${uri}/employee`,
            {},
            createAuthorizationHeadersFromToken(token),
          )

          return {
            id: data.meta.first_name,
            firstName: data.meta.first_name,
            lastName: data.meta.surname,
            email: data.meta.email,
            phone: data.meta.phone_number,
            status: data.meta['employee-registration-status'],
          }
        } catch (e) {
          console.log(e)
          return {
            id: decoded?.id ?? '',
            firstName: decoded?.firstName,
            lastName: decoded?.lastName,
            email: '',
            phone: '',
            status: '',
          }
        }
      }),
    registerVolunteer: (input) =>
      getValidAccessToken()
        .then(({ token, decoded }) =>
          post(
            `${uri}/employee`,
            {
              title: 'employee from insomnia',
              status: 'pending',
              email: input.email,
              national_identity_number: decoded?.id ?? '',
              first_name: decoded?.firstName ?? '',
              surname: decoded?.lastName ?? '',
              ...(input?.phoneNumber && input?.phoneNumber.length > 0
                ? {
                    phone_number: input.phoneNumber,
                  }
                : {}),
            },
            createAuthorizationHeadersFromToken(token),
          ),
        )
        .then((response) => ({
          id: response.data.meta.first_name,
          firstName: response.data.meta.first_name,
          lastName: response.data.meta.surname,
          email: response.data.meta.email,
          phone: response.data.meta.phone_number,
          status: response.data.meta['employee-registration-status'],
        })),
    registerAssignment: (input) =>
      post(
        `${uri}'/assignment'`,
        {
          title: input.title,
          status: 'draft',
        },
        createAuthorizationHeadersFromBase64Secret(''),
      ).then((response) => response.data?.data?.me),
  }
