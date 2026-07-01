import type { ReactNode } from 'react'

type StatusGridItem = {
  label: string
  value: ReactNode
}

type StatusGridProps = {
  items: StatusGridItem[]
}

export function StatusGrid({ items }: StatusGridProps) {
  return (
    <section className="status-grid" aria-label="Статус сервисов">
      {items.map((item) => (
        <div className="status-grid__item" key={item.label}>
          <span className="text-label">{item.label}</span>
          <strong>{item.value}</strong>
        </div>
      ))}
    </section>
  )
}
