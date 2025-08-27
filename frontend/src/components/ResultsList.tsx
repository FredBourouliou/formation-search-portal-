import { Formation } from '../types';

interface ResultsListProps {
  formations: Formation[];
  highlightedId?: string;
  onFormationHover?: (id: string | null) => void;
  onFormationClick?: (formation: Formation) => void;
}

export function ResultsList({ 
  formations, 
  highlightedId,
  onFormationHover,
  onFormationClick 
}: ResultsListProps) {
  const formatDate = (dateString?: string) => {
    if (!dateString) return null;
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR', { 
      day: 'numeric', 
      month: 'long', 
      year: 'numeric' 
    });
  };

  const getModaliteColor = (modalite: string) => {
    switch (modalite) {
      case 'presentiel':
        return 'bg-green-100 text-green-800';
      case 'distanciel':
        return 'bg-blue-100 text-blue-800';
      case 'hybride':
        return 'bg-purple-100 text-purple-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  };

  return (
    <div className="space-y-4">
      {formations.map((formation) => (
        <div
          key={formation.id}
          className={`bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow cursor-pointer ${
            highlightedId === formation.id ? 'ring-2 ring-blue-500' : ''
          }`}
          onMouseEnter={() => onFormationHover?.(formation.id)}
          onMouseLeave={() => onFormationHover?.(null)}
          onClick={() => onFormationClick?.(formation)}
        >
          <div className="flex justify-between items-start mb-2">
            <h3 className="text-lg font-semibold text-gray-900">{formation.titre}</h3>
            <span className={`px-2 py-1 text-xs font-medium rounded-full ${getModaliteColor(formation.modalite)}`}>
              {formation.modalite}
            </span>
          </div>
          
          <p className="text-sm text-gray-600 mb-2">{formation.organisme}</p>
          
          <div className="flex flex-wrap gap-4 text-sm text-gray-500">
            <div className="flex items-center">
              <svg className="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              {formation.ville} ({formation.departement})
            </div>
            
            {(formation.date_debut || formation.date_fin) && (
              <div className="flex items-center">
                <svg className="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {formatDate(formation.date_debut)} {formation.date_fin && `- ${formatDate(formation.date_fin)}`}
              </div>
            )}
          </div>
          
          {formation.url && (
            <a
              href={formation.url}
              target="_blank"
              rel="noopener noreferrer"
              className="inline-flex items-center mt-3 text-sm text-blue-600 hover:text-blue-800"
              onClick={(e) => e.stopPropagation()}
            >
              Plus d'informations
              <svg className="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
              </svg>
            </a>
          )}
        </div>
      ))}
    </div>
  );
}