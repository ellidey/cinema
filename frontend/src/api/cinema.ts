import { httpClient } from './httpClient'

type ApiCollection<T> = {
  data: T[]
}

type ApiResource<T> = {
  data: T
}

export type Movie = {
  id: number
  title: string
  image: string | null
  image_url: string | null
  description: string | null
  duration: number
}

export type Hall = {
  id: number
  name: string
}

export type Seat = {
  id: number
  name: string
  row: number
  number: number
  price: string
  hall_id: number
}

export type Showtime = {
  id: number
  starts_at: string
  movie_id: number
  hall_id: number
  movie?: Movie
  hall?: Hall
  reserved_seats_count?: number
}

export type ReservedSeat = {
  id: number
  reserved_at: string
  seat_id: number
  showtime_id: number
  price: string
  status: 'unpaid' | 'paid'
  seat?: Seat
  showtime?: Showtime
}

export async function getMovies() {
  const response = await httpClient.get<ApiCollection<Movie>>('/movies')

  return response.data.data
}

export async function getMovie(movieId: number) {
  const response = await httpClient.get<ApiResource<Movie>>(`/movies/${movieId}`)

  return response.data.data
}

export async function getShowtimes() {
  const response = await httpClient.get<ApiCollection<Showtime>>('/showtimes')

  return response.data.data
}

export async function getShowtime(showtimeId: number) {
  const response = await httpClient.get<ApiResource<Showtime>>(`/showtimes/${showtimeId}`)

  return response.data.data
}

export async function getSeats(hallId: number) {
  const response = await httpClient.get<ApiCollection<Seat>>('/seats', {
    params: { hall_id: hallId },
  })

  return response.data.data
}

export async function getReservedSeats(showtimeId: number) {
  const response = await httpClient.get<ApiCollection<ReservedSeat>>('/reserved-seats', {
    params: { showtime_id: showtimeId },
  })

  return response.data.data
}

export async function createReservedSeat(payload: { seat_id: number; showtime_id: number }) {
  const response = await httpClient.post<ApiResource<ReservedSeat>>('/reserved-seats', payload)

  return response.data.data
}

export async function payReservedSeat(reservedSeatId: number) {
  const response = await httpClient.patch<ApiResource<ReservedSeat>>(
    `/reserved-seats/${reservedSeatId}/pay`,
  )

  return response.data.data
}
