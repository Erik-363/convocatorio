Diagrama Entidad-Relación (ER)

A continuación se presenta el diagrama ER en formato Mermaid (puede renderizarse en visores compatibles):

```mermaid
erDiagram
    AEROLINEAS {
        INT id PK "Identificador"
        VARCHAR nombre
        TIMESTAMP created_at
    }
    CIUDADES {
        INT id PK
        VARCHAR nombre
        TIMESTAMP created_at
    }
    AEROLINEA_CIUDAD {
        INT id PK
        INT aerolinea_id FK
        INT ciudad_id FK
        TIMESTAMP created_at
    }
    VUELOS {
        INT id PK
        INT aerolinea_id FK
        INT origen_id FK
        INT destino_id FK
        DATE fecha_ida
        DATE fecha_regreso
        INT pasajeros
        TIMESTAMP created_at
    }

    AEROLINEAS ||--o{ AEROLINEA_CIUDAD : "ofrece"
    CIUDADES ||--o{ AEROLINEA_CIUDAD : "es_parte_de"
    AEROLINEAS ||--o{ VUELOS : "opera"
    CIUDADES ||--o{ VUELOS : "origen_de"
    CIUDADES ||--o{ VUELOS : "destino_de"
```

Entidades:
- `aerolineas`
- `ciudades`
- `aerolinea_ciudad` (tabla intermedia)
- `vuelos`

Relaciones y cardinalidades:
- Una aerolínea puede ofrecer muchas ciudades (vía `aerolinea_ciudad`): 1..* (aerolineas) a 0..* (aerolinea_ciudad).
- Una ciudad puede pertenecer a muchas aerolíneas (muchos a muchos mediante `aerolinea_ciudad`).
- Un vuelo está asociado a una aerolínea y dos ciudades (origen y destino).
