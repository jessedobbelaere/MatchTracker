//
//  Match.h
//  MatchTrackerApp
//
//  Created by Jesse on 11/01/13.
//  Copyright (c) 2013 Jesse. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Team.h"

@interface Match : NSObject

@property (nonatomic, retain) NSString* identifier;
@property (nonatomic, retain) NSDate* startTime;
@property (nonatomic, retain) Team* homeTeam;
@property (nonatomic, retain) Team* awayTeam;
@property (nonatomic, retain) NSNumber* homeScore;
@property (nonatomic, retain) NSNumber* awayScore;

@end
