//
//  Competition.h
//  MatchTrackerApp
//
//  Created by Jesse on 10/01/13.
//  Copyright (c) 2013 Jesse. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface Competition : NSObject

@property (nonatomic, retain) NSString* identifier;
@property (nonatomic, retain) NSString* name;
@property (nonatomic, retain) NSString* name_canonical;
@property (nonatomic, retain) NSString* description;
@property (nonatomic, retain) NSString* number_of_teams;
@property (nonatomic, retain) NSDate* startdate;
@property (nonatomic, retain) NSDate* enddate;
@property (nonatomic, retain) NSString* players_on_field;
@property (nonatomic, retain) NSString* place;
@property (nonatomic, retain) NSString* sportType;
@property (nonatomic, retain) NSSet* teams;

@end
