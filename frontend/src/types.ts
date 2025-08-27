export interface Formation {
  id: string;
  titre: string;
  organisme: string;
  departement: string;
  ville: string;
  modalite: 'presentiel' | 'distanciel' | 'hybride';
  latitude?: number;
  longitude?: number;
  date_debut?: string;
  date_fin?: string;
  url?: string;
}

export interface FormationsResponse {
  items: Formation[];
  total: number;
  page: number;
  limit: number;
  pages: number;
}

export interface FormationFilters {
  q?: string;
  departement?: string;
  modalite?: string;
  page?: number;
  limit?: number;
}