//
//  MatchesViewController.m
//  MatchTrackerApp
//
//  Created by Jesse on 11/01/13.
//  Copyright (c) 2013 Jesse. All rights reserved.
//

#import "MatchesViewController.h"
#import <RestKit/RestKit.h>
#import "Match.h"
#import "MatchDetailViewController.h"


@interface MatchesViewController ()

@end

@implementation MatchesViewController

- (id)initWithStyle:(UITableViewStyle)style
{
    self = [super initWithStyle:style];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    [self loadMatches];

    // Uncomment the following line to preserve selection between presentations.
    // self.clearsSelectionOnViewWillAppear = NO;
 
    // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
    // self.navigationItem.rightBarButtonItem = self.editButtonItem;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

#pragma mark - Table view data source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    // Return the number of sections.
    return 1;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    // Return the number of rows in the section.
    return [self.matches count];
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"MatchCell"];
	Match *match = [self.matches objectAtIndex:indexPath.row];
	cell.textLabel.text = [NSString stringWithFormat:@"%@ - %@", match.homeTeam.name, match.awayTeam.name];

    NSDateFormatter *dateFormat = [[NSDateFormatter alloc] init];
    [dateFormat setDateFormat:@"dd/MM"];
    
    NSDateFormatter *timeFormat = [[NSDateFormatter alloc] init];
    [timeFormat setDateFormat:@"HH:mm"];
    
    NSString *theDate = [dateFormat stringFromDate:match.startTime];
    NSString *theTime = [timeFormat stringFromDate:match.startTime];
	
    cell.detailTextLabel.text = [NSString stringWithFormat:@"%@ %@", theDate, theTime];
    return cell;
}


- (void) loadMatches
{
    // Create our new Author mapping
    RKObjectMapping* teamMapping = [RKObjectMapping mappingForClass:[Team class] ];
    [teamMapping addAttributeMappingsFromDictionary:@{
     @"id": @"identifier",
     @"name": @"name",
     @"email": @"email",
     }];
    
    
    // Competition mapping
    RKObjectMapping* articleMapping = [RKObjectMapping mappingForClass:[Match class]];
    [articleMapping addAttributeMappingsFromDictionary:@{
     @"id": @"identifier",
     @"start_time": @"startTime",
     }];
    
    // Add relationship
    [articleMapping addPropertyMapping:[RKRelationshipMapping relationshipMappingFromKeyPath:@"home_team" toKeyPath:@"homeTeam" withMapping:teamMapping]];
    [articleMapping addPropertyMapping:[RKRelationshipMapping relationshipMappingFromKeyPath:@"away_team" toKeyPath:@"awayTeam" withMapping:teamMapping]];
    
    RKResponseDescriptor *responseDescriptor = [RKResponseDescriptor responseDescriptorWithMapping:articleMapping pathPattern:nil keyPath:@"matches" statusCodes:RKStatusCodeIndexSetForClass(RKStatusCodeClassSuccessful)];
    
    NSURL *URL = [NSURL URLWithString:@"http://matchtracker.localhost/app_dev.php/api/matches"];
    NSURLRequest *request = [NSURLRequest requestWithURL:URL];
    RKObjectRequestOperation *objectRequestOperation = [[RKObjectRequestOperation alloc] initWithRequest:request responseDescriptors:@[ responseDescriptor ]];
    [objectRequestOperation setCompletionBlockWithSuccess:^(RKObjectRequestOperation *operation, RKMappingResult *mappingResult) {
        //RKLogInfo(@"Loaded collection of %i Leagues", [mappingResult count]);
        
        // Set data
        self.matches = [mappingResult array];
        
        // Console print the retrieved competitions
//        for(Competition *competition in [mappingResult array]) {
//            NSLog(@"Match met id=%@ en naam=%@", competition.identifier, [competition name]);
//        }
        
        // Reload the table
        [self.tableView reloadData];
        
        // Stop loading
        [self stopLoading];
        
    } failure:^(RKObjectRequestOperation *operation, NSError *error) {
        RKLogError(@"Operation failed with error: %@", error);
    }];
    
    [objectRequestOperation start];
}

// Pull to refresh implementation
- (void)refresh {
    [self performSelector:@selector(loadMatches) withObject:nil afterDelay:0];
}


/*
// Override to support conditional editing of the table view.
- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Return NO if you do not want the specified item to be editable.
    return YES;
}
*/

/*
// Override to support editing the table view.
- (void)tableView:(UITableView *)tableView commitEditingStyle:(UITableViewCellEditingStyle)editingStyle forRowAtIndexPath:(NSIndexPath *)indexPath
{
    if (editingStyle == UITableViewCellEditingStyleDelete) {
        // Delete the row from the data source
        [tableView deleteRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationFade];
    }   
    else if (editingStyle == UITableViewCellEditingStyleInsert) {
        // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
    }   
}
*/

/*
// Override to support rearranging the table view.
- (void)tableView:(UITableView *)tableView moveRowAtIndexPath:(NSIndexPath *)fromIndexPath toIndexPath:(NSIndexPath *)toIndexPath
{
}
*/

/*
// Override to support conditional rearranging of the table view.
- (BOOL)tableView:(UITableView *)tableView canMoveRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Return NO if you do not want the item to be re-orderable.
    return YES;
}
*/

#pragma mark - Table view delegate

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Navigation logic may go here. Create and push another view controller.
    /*
     <#DetailViewController#> *detailViewController = [[<#DetailViewController#> alloc] initWithNibName:@"<#Nib name#>" bundle:nil];
     // ...
     // Pass the selected object to the new view controller.
     [self.navigationController pushViewController:detailViewController animated:YES];
     */
}

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    // Get row index
    NSIndexPath *indexPath = [self.tableView indexPathForSelectedRow];
    
    // Get reference to the destination view controller
    MatchDetailViewController *vc = [segue destinationViewController];
    
    // Pass any objects to the view controller here, like...
    vc.identifier = [[self.matches objectAtIndex:indexPath.row] identifier];
}

@end
