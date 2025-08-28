import { useEffect, useRef } from 'react';
import { MapContainer, TileLayer, Marker, Popup, useMap } from 'react-leaflet';
import L from 'leaflet';
import { Formation } from '../types';

import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

delete (L.Icon.Default.prototype as any)._getIconUrl;
L.Icon.Default.mergeOptions({
  iconUrl: markerIcon,
  iconRetinaUrl: markerIcon2x,
  shadowUrl: markerShadow,
});

interface MapViewProps {
  formations: Formation[];
  highlightedId?: string;
  onMarkerClick?: (formation: Formation) => void;
  onMarkerHover?: (id: string | null) => void;
}

function MapController({ formations }: { formations: Formation[] }) {
  const map = useMap();
  
  useEffect(() => {
    if (formations.length > 0) {
      const bounds = L.latLngBounds(
        formations
          .filter(f => f.latitude && f.longitude)
          .map(f => [f.latitude!, f.longitude!] as [number, number])
      );
      
      if (bounds.isValid()) {
        map.fitBounds(bounds, { padding: [50, 50] });
      }
    }
  }, [formations, map]);
  
  return null;
}

export function MapView({ 
  formations, 
  highlightedId,
  onMarkerClick,
  onMarkerHover 
}: MapViewProps) {
  const mapRef = useRef<L.Map | null>(null);
  
  const formationsWithCoords = formations.filter(f => f.latitude && f.longitude);
  
  const defaultIcon = new L.Icon({
    iconUrl: markerIcon,
    iconRetinaUrl: markerIcon2x,
    shadowUrl: markerShadow,
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41],
  });
  
  const highlightedIcon = new L.Icon({
    iconUrl: markerIcon,
    iconRetinaUrl: markerIcon2x,
    shadowUrl: markerShadow,
    iconSize: [35, 51],
    iconAnchor: [17, 51],
    popupAnchor: [1, -34],
    shadowSize: [51, 51],
    className: 'highlighted-marker',
  });
  
  useEffect(() => {
    if (highlightedId && mapRef.current) {
      const formation = formationsWithCoords.find(f => f.id === highlightedId);
      if (formation && formation.latitude && formation.longitude) {
        mapRef.current.panTo([formation.latitude, formation.longitude], {
          animate: true,
          duration: 0.5,
        });
      }
    }
  }, [highlightedId, formationsWithCoords]);
  
  return (
    <div className="h-full w-full rounded-lg overflow-hidden shadow-md">
      <MapContainer
        center={[47.322047, 5.04148]}
        zoom={8}
        className="h-full w-full"
        ref={mapRef}
      >
        <TileLayer
          attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
        />
        <MapController formations={formationsWithCoords} />
        {formationsWithCoords.map((formation) => (
          <Marker
            key={formation.id}
            position={[formation.latitude!, formation.longitude!]}
            icon={formation.id === highlightedId ? highlightedIcon : defaultIcon}
            eventHandlers={{
              click: () => onMarkerClick?.(formation),
              mouseover: () => onMarkerHover?.(formation.id),
              mouseout: () => onMarkerHover?.(null),
            }}
          >
            <Popup>
              <div className="p-2">
                <h4 className="font-semibold">{formation.titre}</h4>
                <p className="text-sm text-gray-600">{formation.organisme}</p>
                <p className="text-sm">{formation.ville} ({formation.departement})</p>
                <span className="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100">
                  {formation.modalite}
                </span>
              </div>
            </Popup>
          </Marker>
        ))}
      </MapContainer>
    </div>
  );
}