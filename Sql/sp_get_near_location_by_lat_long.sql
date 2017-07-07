ALTER PROCEDURE sp_get_near_location_by_lat_long
@latitude FLOAT,
@longitude FLOAT
AS
BEGIN
	
	
			DECLARE @orig geography = geography::Point(@latitude, @longitude, 4326);

				
			select name, directions, lat, long, place_id
				app.CalculateDistance(@latitude, @longitude, lat, long) as Distance,
				@orig.STDistance(geography::Point(lat, long, 4326)) AS distance2,				

			from location
					
			where udf_Haversine(lat, long, @latitude, @longitude) < 1.24 --millas
			
		

END
