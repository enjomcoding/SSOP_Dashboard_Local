/**
 * Normalize Laravel paginator JSON (default or meta wrapper) from axios response body.
 */
export function normalizePaginatedResponse(body) {
  if (!body || typeof body !== 'object') {
    return emptyPagination();
  }

  if (Array.isArray(body.data) && body.current_page != null) {
    return {
      records: body.data,
      current_page: body.current_page,
      last_page: body.last_page,
      per_page: body.per_page,
      total: body.total,
      from: body.from,
      to: body.to,
      links: body.links,
    };
  }

  if (Array.isArray(body.data) && body.meta) {
    const { meta, links } = body;
    return {
      records: body.data,
      current_page: meta.current_page,
      last_page: meta.last_page,
      per_page: meta.per_page,
      total: meta.total,
      from: meta.from,
      to: meta.to,
      links: links ?? meta.links,
    };
  }

  if (Array.isArray(body)) {
    return {
      ...emptyPagination(),
      records: body,
      total: body.length,
      last_page: 1,
    };
  }

  return emptyPagination();
}

function emptyPagination() {
  return {
    records: [],
    current_page: 1,
    last_page: 1,
    per_page: 15,
    total: 0,
    from: null,
    to: null,
    links: null,
  };
}
