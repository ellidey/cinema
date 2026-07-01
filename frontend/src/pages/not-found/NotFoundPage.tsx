import { Link } from 'react-router-dom'
import { Page } from '../../components/Page'

export function NotFoundPage() {
  return (
    <Page>
      <section className="not-found">
        <p className="text-label">
          <i className="ri-error-warning-line" aria-hidden="true" />
          404
        </p>
        <h1>Страница не найдена</h1>
        <p>Такого адреса нет. Вернитесь к списку фильмов и выберите доступный сеанс.</p>
        <Link className="not-found__link" to="/">
          <i className="ri-home-4-line" aria-hidden="true" />
          На главную
        </Link>
      </section>
    </Page>
  )
}
