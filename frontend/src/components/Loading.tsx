export function Loading() {
  return (
    <div className="flex justify-center items-center py-12" role="status" aria-label="Chargement">
      <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      <span className="sr-only">Chargement...</span>
    </div>
  );
}