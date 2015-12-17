--------------------------------------------------------
--  Ref Constraints for Table TPYE_TRAIN
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."TPYE_TRAIN" ADD CONSTRAINT "TPYE_TRAIN_FK1" FOREIGN KEY ("NO_TRAIN")
	  REFERENCES "SYSTEM"."TRAIN" ("NO_TRAIN") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table TICKET_PRODUCT
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."TICKET_PRODUCT" ADD CONSTRAINT "TICKET_PRODUCT_FK1" FOREIGN KEY ("NO_TRAIN")
	  REFERENCES "SYSTEM"."TRAIN" ("NO_TRAIN") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table STATION_BETWEEN
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."STATION_BETWEEN" ADD CONSTRAINT "STATION_BETWEEN_FK1" FOREIGN KEY ("STATION_START")
	  REFERENCES "SYSTEM"."STATION" ("STATION_NAME") ENABLE;
  ALTER TABLE "SYSTEM"."STATION_BETWEEN" ADD CONSTRAINT "STATION_BETWEEN_FK2" FOREIGN KEY ("STATION_END")
	  REFERENCES "SYSTEM"."STATION" ("STATION_NAME") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table BOGIE
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."BOGIE" ADD CONSTRAINT "BOGIE_FK1" FOREIGN KEY ("NO_TRAIN")
	  REFERENCES "SYSTEM"."TRAIN" ("NO_TRAIN") ENABLE;
