import { Formation, FormationsResponse, FormationFilters } from '../types';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8080';

export class ApiError extends Error {
  constructor(public status: number, message: string) {
    super(message);
    this.name = 'ApiError';
  }
}

async function fetchApi<T>(endpoint: string, options?: RequestInit): Promise<T> {
  const url = `${API_BASE_URL}${endpoint}`;
  
  try {
    const response = await fetch(url, {
      ...options,
      headers: {
        'Content-Type': 'application/json',
        ...options?.headers,
      },
    });

    if (!response.ok) {
      throw new ApiError(response.status, `API Error: ${response.statusText}`);
    }

    return await response.json();
  } catch (error) {
    if (error instanceof ApiError) {
      throw error;
    }
    throw new Error(`Network error: ${error instanceof Error ? error.message : 'Unknown error'}`);
  }
}

export const api = {
  formations: {
    list: async (filters: FormationFilters = {}): Promise<FormationsResponse> => {
      const params = new URLSearchParams();
      
      if (filters.q) params.append('q', filters.q);
      if (filters.departement) params.append('departement', filters.departement);
      if (filters.modalite) params.append('modalite', filters.modalite);
      if (filters.page) params.append('page', filters.page.toString());
      if (filters.limit) params.append('limit', filters.limit.toString());
      
      const queryString = params.toString();
      const endpoint = queryString ? `/formations?${queryString}` : '/formations';
      
      return fetchApi<FormationsResponse>(endpoint);
    },
    
    get: async (id: string): Promise<Formation> => {
      return fetchApi<Formation>(`/formations/${id}`);
    },
  },
  
  health: async (): Promise<{ status: string }> => {
    return fetchApi<{ status: string }>('/health');
  },
};