# Laravel Real Estate API

A RESTful API built with Laravel to power real estate platforms with advanced property listings, filtering, and user authentication.

## Caching Strategy

### Property Details

* **Key:** `property_show_{id}`
* **Duration:** **10 Minutes**
* **Rationale:** Property details are highly requested but change infrequently. A 10-minute TTL ensures high performance and reduces database load, while keeping the data fresh enough to reflect critical updates like status changes or featured visibility.
* **Cache Invalidation:** The cache key is immediately cleared whenever the property status changes (e.g., marked as *Sold*) or when its features/premium status are updated.

### Featured Properties

* **Cache Tag:** `featured_properties`
* **Duration:** **10 Minutes**
* **Rationale:** The featured properties list is the most heavily trafficked endpoint on the platform (usually displayed on the homepage). Caching pages under a unified tag for 10 minutes drastically cuts down complex database queries and speeds up response times for users, while properly handling paginated results.
* **Cache Invalidation:** The entire cache tag is automatically flushed whenever any property is marked/unmarked as *Featured*, or when a featured property is *Sold*.

### Agency Properties

* **Cache Tag:** `user_{id}_properties`
* **Duration:** **20 Minutes**
* **Rationale:** Agency portfolios are relatively static. Using cache tags allows effective caching of all paginated pages for a specific agency, optimizing database performance for dedicated agency pages without risking stale or broken inventories across pages.
* **Cache Invalidation:** The specific agency's cache tag is immediately flushed whenever that agency adds a new property listing, or when any of their existing properties are marked as *Sold*.


### City Properties Count

* **Key:** `city:{id}:count`
* **Duration:** **10 Minutes**
* **Rationale:** Displaying the total number of available listings per city is common on homepages and search filters. Since counting rows across large datasets is resource-intensive for the database, caching this count for 10 minutes significantly accelerates page loads while keeping the metrics accurate.
* **Cache Invalidation:** The cache key is instantly cleared whenever a new property is added to that specific city, or when an existing property within that city is marked as *Sold*.

## API Versioning

We utilize **URI Versioning** (e.g., /v1/...) because it provides explicit clarity for frontend integration, simplifies routing within Laravel.