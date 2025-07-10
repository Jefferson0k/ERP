export type ProspectoRequest = {
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
