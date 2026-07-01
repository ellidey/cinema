import { useEffect, useMemo, useState } from 'react'
import { Link, useParams } from 'react-router-dom'
import {
  createReservedSeat,
  getReservedSeats,
  getSeats,
  getShowtime,
  type ReservedSeat,
  type Seat,
  type Showtime,
} from '../../api/cinema'
import { BookingModal } from '../../components/BookingModal'
import { Page } from '../../components/Page'

export function ShowtimePage() {
  const { showtimeId } = useParams()
  const parsedShowtimeId = Number(showtimeId)
  const [showtime, setShowtime] = useState<Showtime | null>(null)
  const [seats, setSeats] = useState<Seat[]>([])
  const [reservedSeats, setReservedSeats] = useState<ReservedSeat[]>([])
  const [selectedSeat, setSelectedSeat] = useState<Seat | null>(null)
  const [isSubmitting, setIsSubmitting] = useState(false)
  const [error, setError] = useState<string | null>(null)
  const [isLoading, setIsLoading] = useState(true)

  useEffect(() => {
    if (!Number.isFinite(parsedShowtimeId)) {
      return
    }

    getShowtime(parsedShowtimeId)
      .then((showtimeData) => {
        setShowtime(showtimeData)
        return Promise.all([getSeats(showtimeData.hall_id), getReservedSeats(showtimeData.id)])
      })
      .then(([seatData, reservedSeatData]) => {
        setSeats(seatData)
        setReservedSeats(reservedSeatData)
      })
      .finally(() => setIsLoading(false))
  }, [parsedShowtimeId])

  const reservedSeatsBySeatId = useMemo(() => {
    return new Map(reservedSeats.map((reservedSeat) => [reservedSeat.seat_id, reservedSeat]))
  }, [reservedSeats])

  const seatsByRow = useMemo(() => {
    return seats.reduce<Record<number, Seat[]>>((groups, seat) => {
      groups[seat.row] ??= []
      groups[seat.row].push(seat)
      groups[seat.row].sort((left, right) => left.number - right.number)

      return groups
    }, {})
  }, [seats])

  function handleBookingSubmit() {
    if (!selectedSeat || !showtime) {
      return
    }

    setIsSubmitting(true)
    setError(null)

    createReservedSeat({
      seat_id: selectedSeat.id,
      showtime_id: showtime.id,
    })
      .then((reservedSeat) => {
        setReservedSeats((currentReservedSeats) => [...currentReservedSeats, reservedSeat])
        setSelectedSeat(null)
      })
      .catch(() => {
        setError('Место уже занято')
      })
      .finally(() => {
        setIsSubmitting(false)
      })
  }

  if (isLoading) {
    return <Page>Загрузка...</Page>
  }

  if (!showtime || !showtime.movie) {
    return <Page>Сеанс не найден</Page>
  }

  return (
    <Page>
      <Link className="back-link" to={`/movies/${showtime.movie.id}`}>
        <i className="ri-arrow-left-line" aria-hidden="true" />
        Назад к сеансам
      </Link>

      <article className="showtime-detail">
        <img className="showtime-detail__poster" src={showtime.movie.image_url ?? ''} alt="" />
        <div>
          <p className="text-label">
            <i className="ri-calendar-event-line" aria-hidden="true" />
            {formatDateTime(showtime.starts_at)}
          </p>
          <h1>{showtime.movie.title}</h1>
          <p>{showtime.movie.description}</p>
        </div>
      </article>

      <section className="seat-map" aria-label="Схема мест">
        <div className="screen">
          <i className="ri-film-line" aria-hidden="true" />
          Экран
        </div>

        <div className="seat-rows">
          {Object.entries(seatsByRow).map(([row, rowSeats]) => (
            <div className="seat-row" key={row}>
              <span className="seat-row__label">Ряд {row}</span>
              <div className="seat-row__items">
                {rowSeats.map((seat) => {
                  const reservedSeat = reservedSeatsBySeatId.get(seat.id)
                  const isReserved = Boolean(reservedSeat)
                  const statusClass =
                    reservedSeat?.status === 'paid' ? 'seat--paid' : reservedSeat ? 'seat--unpaid' : ''

                  return (
                    <button
                      className={`seat ${statusClass}`}
                      type="button"
                      key={seat.id}
                      disabled={isReserved}
                      onClick={() => setSelectedSeat(seat)}
                    >
                      <span>{seat.number}</span>
                      <small>{seat.price} ₽</small>
                    </button>
                  )
                })}
              </div>
            </div>
          ))}
        </div>
      </section>

      {selectedSeat ? (
        <BookingModal
          seat={selectedSeat}
          isSubmitting={isSubmitting}
          error={error}
          onClose={() => {
            setSelectedSeat(null)
            setError(null)
          }}
          onSubmit={handleBookingSubmit}
        />
      ) : null}
    </Page>
  )
}

function formatDateTime(value: string) {
  return new Intl.DateTimeFormat('ru-RU', {
    day: '2-digit',
    month: 'long',
    hour: '2-digit',
    minute: '2-digit',
  }).format(new Date(value))
}
