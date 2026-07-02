import { type FormEvent, useState } from 'react'
import { type Seat } from '../api/cinema'

type BookingModalProps = {
  seat: Seat
  isSubmitting: boolean
  error: string | null
  onClose: () => void
  onSubmit: () => void
}

export function BookingModal({ seat, isSubmitting, error, onClose, onSubmit }: BookingModalProps) {
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')

  function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault()
    onSubmit()
  }

  return (
    <div className="modal-backdrop" role="presentation">
      <section className="booking-modal" role="dialog" aria-modal="true" aria-labelledby="booking-title">
        <div className="booking-modal__header">
          <div>
            <p className="text-label">
              <i className="ri-armchair-line" aria-hidden="true" />
              Место {seat.name}
            </p>
            <h2 id="booking-title">Оплатить</h2>
          </div>
          <button className="icon-button" type="button" onClick={onClose} aria-label="Закрыть">
            <i className="ri-close-line" aria-hidden="true" />
          </button>
        </div>

        <dl className="booking-modal__summary">
          <div>
            <dt>Ряд</dt>
            <dd>{seat.row}</dd>
          </div>
          <div>
            <dt>Место</dt>
            <dd>{seat.number}</dd>
          </div>
          <div>
            <dt>Цена</dt>
            <dd>{seat.price} ₽</dd>
          </div>
        </dl>

        <form className="booking-form" onSubmit={handleSubmit}>
          <label>
            Имя
            <input value={name} onChange={(event) => setName(event.target.value)} required />
          </label>
          <label>
            Email
            <input
              type="email"
              value={email}
              onChange={(event) => setEmail(event.target.value)}
              required
            />
          </label>

          {error ? <p className="form-error">{error}</p> : null}

          <div className="booking-form__actions">
            <button className="button button--secondary" type="button" onClick={onClose}>
              <i className="ri-close-circle-line" aria-hidden="true" />
              Отмена
            </button>
            <button className="button" type="submit" disabled={isSubmitting}>
              <i className="ri-ticket-2-line" aria-hidden="true" />
              {isSubmitting ? 'Оплачиваем...' : 'Оплатить'}
            </button>
          </div>
        </form>
      </section>
    </div>
  )
}
