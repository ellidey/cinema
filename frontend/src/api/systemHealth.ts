import { useEffect, useState } from 'react'
import { httpClient } from './httpClient'

export type SystemHealth = {
  status: string
  service: string
}

type SystemHealthState = {
  data: SystemHealth | null
  error: string | null
  isLoading: boolean
}

export async function getSystemHealth() {
  const response = await httpClient.get<SystemHealth>('/health')

  return response.data
}

export function useSystemHealth() {
  const [state, setState] = useState<SystemHealthState>({
    data: null,
    error: null,
    isLoading: true,
  })

  useEffect(() => {
    let isMounted = true

    getSystemHealth()
      .then((data) => {
        if (!isMounted) {
          return
        }

        setState({ data, error: null, isLoading: false })
      })
      .catch(() => {
        if (!isMounted) {
          return
        }

        setState({
          data: null,
          error: 'API недоступен',
          isLoading: false,
        })
      })

    return () => {
      isMounted = false
    }
  }, [])

  return state
}
