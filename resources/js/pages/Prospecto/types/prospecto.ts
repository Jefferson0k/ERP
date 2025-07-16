export type ProspectoRucRequest = {
  ruc: string;
  business_name: string;
  trade_name?: string;
  address: string;
  economic_activity?: string;
  registration_date?: string;
  email?: string;
  website?: string;
  sales_executive: string;
  contact_person?: string;
  position?: string;
  expected_rate?: number;
  commission?: number;
  notes?: string;

  dni: string; //tony
  nombre: string; //tony
  numero_movil: string; //tony
};

export type ProspectoResource = {
  id: number;
  ruc: string;
  business_name: string;
  trade_name: string | null;
  address: string;
  economic_activity: string | null;
  activity_start_date: string | null;
  email: string | null;
  website: string | null;
  sales_executive: string;
  contact_person: string | null;
  position: string | null;
  expected_rate: number | null;
  commission: number | null;
  notes: string | null;
  created_at: string;
  updated_at: string;

  dni: string; //tony
  nombre: string; //tony
  numero_movil: string; //tony
};

export type ProspectoDniRequest = {
  dni: string; //tony
  activity_start_date: string | null;
  sales_executive: string;
  nombre: string; //tony
  address: string;
  fecha_nacimiento: string | null; //tony
  sexo: string; //tony
  estado_civil: string; //tony
  expected_rate: number | null;
  commission: number | null;
  email: string | null;
  numero_movil: string; //tony
};

export type ProspectoCeRequest = {
  ce: string; //tony
  activity_start_date: string | null;
  sales_executive: string;
  nombre: string; //tony
  address: string;
  fecha_nacimiento: string | null; //tony
  sexo: string; //tony
  estado_civil: string; //tony
  expected_rate: number | null;
  commission: number | null;
  email: string | null;
  numero_movil: string; //tony
};

export type ProspectoDniResource = {
  dni: string; //tony
  activity_start_date: string | null;
  sales_executive: string;
  nombre: string; //tony
  address: string;
  fecha_nacimiento: string | null; //tony
  sexo: string; //tony
  estado_civil: string; //tony
  expected_rate: number | null;
  commission: number | null;
  email: string | null;
  numero_movil: string; //tony
};

export type ProspectoCreateResponse = {
  message: string;
  data: ProspectoResource;
};

export type ProspectoListResponse = {
  data: ProspectoResource[];
  pagination?: {
    total: number;
    per_page: number;
    current_page: number;
    last_page: number;
  };
};

export interface Prospecto {
  registration_date: string | null
  sales_executive: string | null
  ruc: string | null
  business_name: string | null
  trade_name: string | null
  address: string | null
  economic_activity: string | null
  activity_start_date: string | null
  expected_rate: string | null
  commission: string | null
  contact_person: string | null
  position: string | null
  email: string | null
  website: string | null
  notes: string | null
  created_at: string
  updated_at: string
  dni: string | null
  ce: string | null
  nombre: string | null
  fecha_nacimiento: string | null
  sexo: string | null
  estado_civil: string | null
  numero_movil: string | null
}
